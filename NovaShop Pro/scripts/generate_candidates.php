<?php
// generate_candidates.php
// Génère les top N candidats d'images pour chaque produit et écrit scripts/candidates.csv

declare(strict_types=1);
chdir(__DIR__ . '/..');
$env = require __DIR__ . '/../App/Config/env.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $env['db_host'], $env['db_name']);
try { $pdo = new PDO($dsn, $env['db_user'], $env['db_pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch (PDOException $e) { echo "DB connect error: " . $e->getMessage() . PHP_EOL; exit(1); }

$products = $pdo->query('SELECT id,name,image_url FROM products ORDER BY id')->fetchAll();
$srcDir = __DIR__ . '/../Public/Assets/Images/image_php';
$files = array_values(array_filter(scandir($srcDir), function($f) use ($srcDir){ return is_file($srcDir.'/'.$f); }));
if (!$files) { echo "No source images\n"; exit(1); }

function normalize(string $s): string {
    $s = mb_strtolower($s);
    $s = iconv('UTF-8','ASCII//TRANSLIT',$s);
    $s = preg_replace('/[^a-z0-9 ]+/', ' ', $s);
    $s = preg_replace('/\s+/', ' ', $s);
    return trim($s);
}

$fileNorm = [];
foreach ($files as $f) { $fileNorm[$f] = normalize(pathinfo($f, PATHINFO_FILENAME)); }

$out = fopen(__DIR__ . '/candidates.csv','w');
fputcsv($out, ['product_id','product_name','product_old_image','candidate_rank','candidate_file','score']);

foreach ($products as $p) {
    $pid = (int)$p['id'];
    $pname = normalize($p['name']);
    $scores = [];
    foreach ($fileNorm as $fname => $fnorm) {
        $tokensP = array_filter(explode(' ', $pname));
        $tokensF = array_filter(explode(' ', $fnorm));
        $overlap = 0; foreach ($tokensP as $t) { if (in_array($t,$tokensF)) $overlap++; }
        similar_text($pname, $fnorm, $percent);
        $lev = levenshtein($pname, $fnorm);
        $maxLen = max(1, max(strlen($pname), strlen($fnorm)));
        $levScore = 100 * (1 - ($lev / $maxLen));
        $score = $percent * 0.6 + $levScore * 0.2 + $overlap * 10;
        $scores[$fname] = $score;
    }
    arsort($scores);
    $rank = 1;
    foreach ($scores as $fname=>$score) {
        if ($rank > 5) break;
        fputcsv($out, [$pid, $p['name'], $p['image_url'], $rank, $fname, round($score,2)]);
        $rank++;
    }
}
fclose($out);
echo "Candidates generated: scripts/candidates.csv\n";

?>
