<?php
// import_and_map_images.php
// 1) Backup current image_url values
// 2) Match images from Public/Assets/Images/image_php to products (fuzzy)
// 3) Copy matched files into Public/Assets/Images/products/
// 4) Update DB and write rollback SQL

declare(strict_types=1);

chdir(__DIR__ . '/..'); // project root

$env = require __DIR__ . '/../App/Config/env.php';

$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $env['db_host'], $env['db_name']);
try {
    $pdo = new PDO($dsn, $env['db_user'], $env['db_pass'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    echo "DB connection failed: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

$products = $pdo->query("SELECT id, name, image_url FROM products ORDER BY id")->fetchAll();

$srcDir = __DIR__ . '/../Public/Assets/Images/image_php';
$dstDir = __DIR__ . '/../Public/Assets/Images/products';
if (!is_dir($srcDir)) { echo "Source folder not found: $srcDir" . PHP_EOL; exit(1); }
if (!is_dir($dstDir)) { mkdir($dstDir, 0755, true); }

$files = array_values(array_filter(scandir($srcDir), function($f) use ($srcDir){ return is_file($srcDir . '/' . $f); }));
if (count($files) === 0) { echo "No files to import in $srcDir" . PHP_EOL; exit(1); }

function normalize(string $s): string {
    $s = mb_strtolower($s);
    $s = iconv('UTF-8', 'ASCII//TRANSLIT', $s);
    $s = preg_replace('/[^a-z0-9 ]+/', ' ', $s);
    $s = preg_replace('/\s+/', ' ', $s);
    return trim($s);
}

// Prepare names
$fileKeys = [];
foreach ($files as $f) {
    $name = pathinfo($f, PATHINFO_FILENAME);
    $fileKeys[$f] = normalize($name);
}

// Build candidate scores for each product
$candidates = [];
foreach ($products as $p) {
    $pid = (int)$p['id'];
    $pname = normalize($p['name']);
    $scores = [];
    foreach ($fileKeys as $fname => $fnorm) {
        // token overlap
        $tokensP = array_filter(explode(' ', $pname));
        $tokensF = array_filter(explode(' ', $fnorm));
        $overlap = 0;
        foreach ($tokensP as $t) { if (in_array($t, $tokensF)) $overlap++; }
        // similar_text percent
        similar_text($pname, $fnorm, $percent);
        // levenshtein (normalized)
        $lev = levenshtein($pname, $fnorm);
        $maxLen = max(1, max(strlen($pname), strlen($fnorm)));
        $levScore = 100 * (1 - ($lev / $maxLen));

        // combined score
        $score = $percent * 0.6 + $levScore * 0.2 + $overlap * 10;
        $scores[$fname] = $score;
    }
    // sort descending
    arsort($scores);
    $candidates[$pid] = ['product' => $p, 'scores' => $scores];
}

// Greedy assignment: pick highest-scoring product-file pairs
$assigned = [];
$usedFiles = [];

// Build a flat list of best options
$options = [];
foreach ($candidates as $pid => $info) {
    foreach ($info['scores'] as $fname => $score) {
        $options[] = ['pid' => $pid, 'file' => $fname, 'score' => $score];
    }
}
usort($options, function($a,$b){ return $b['score'] <=> $a['score']; });

foreach ($options as $opt) {
    $pid = $opt['pid'];
    $f = $opt['file'];
    if (isset($assigned[$pid])) continue; // product already assigned
    if (in_array($f, $usedFiles)) continue; // file already used
    // only accept reasonable scores (>20)
    if ($opt['score'] < 20) continue;
    $assigned[$pid] = $f;
    $usedFiles[] = $f;
}

// For unassigned products, allow reuse of files by taking their top candidate
foreach ($candidates as $pid => $info) {
    if (isset($assigned[$pid])) continue;
    $top = key($info['scores']);
    $assigned[$pid] = $top;
}

// Backup current image_url to CSV and generate rollback SQL
$backupCsv = __DIR__ . '/backup_image_urls.csv';
$rollbackSql = __DIR__ . '/rollback_image_urls.sql';
$fp = fopen($backupCsv, 'w');
fputcsv($fp, ['id','name','old_image_url']);
$rb = fopen($rollbackSql, 'w');
fwrite($rb, "-- rollback: restore old image_url values\nSTART TRANSACTION;\n");
foreach ($products as $p) {
    fputcsv($fp, [$p['id'], $p['name'], $p['image_url']]);
    $old = addslashes($p['image_url']);
    fwrite($rb, "UPDATE products SET image_url = '$old' WHERE id = {$p['id']};\n");
}
fwrite($rb, "COMMIT;\n");
fclose($fp);
fclose($rb);

// Apply assignments: copy files and update DB
$proposedCsv = __DIR__ . '/proposed_mappings.csv';
$fp2 = fopen($proposedCsv, 'w');
fputcsv($fp2, ['id','name','old_image_url','new_file','new_image_url']);

$updateStmt = $pdo->prepare("UPDATE products SET image_url = ? WHERE id = ?");

foreach ($assigned as $pid => $fname) {
    $prod = null;
    foreach ($products as $p) { if ((int)$p['id'] === (int)$pid) { $prod = $p; break; } }
    if ($prod === null) continue;

    $src = $srcDir . '/' . $fname;
    if (!is_file($src)) {
        // fallback: skip
        fputcsv($fp2, [$pid, $prod['name'], $prod['image_url'], $fname, 'MISSING']);
        continue;
    }

    $ext = pathinfo($fname, PATHINFO_EXTENSION);
    $safeName = 'product_' . $pid . '_' . preg_replace('/[^a-z0-9_-]/', '_', substr($fileKeys[$fname],0,40));
    $dstName = $safeName . '.' . $ext;
    $dst = $dstDir . '/' . $dstName;
    // copy file
    if (!copy($src, $dst)) {
        fputcsv($fp2, [$pid, $prod['name'], $prod['image_url'], $fname, 'COPY_FAILED']);
        continue;
    }

    $newUrl = '/Assets/Images/products/' . $dstName;
    // update DB
    try {
        $updateStmt->execute([$newUrl, $pid]);
        fputcsv($fp2, [$pid, $prod['name'], $prod['image_url'], $fname, $newUrl]);
    } catch (Exception $e) {
        fputcsv($fp2, [$pid, $prod['name'], $prod['image_url'], $fname, 'UPDATE_FAILED: '.$e->getMessage()]);
    }
}

fclose($fp2);

echo "Done. Backup: $backupCsv, Rollback SQL: $rollbackSql, Proposed mappings: $proposedCsv" . PHP_EOL;
echo "If something looks wrong you can run: php -f $rollbackSql (or import in MySQL)" . PHP_EOL;

?>
