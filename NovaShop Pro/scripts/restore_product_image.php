<?php
// restore_product_image.php
// Usage: php restore_product_image.php <product_id>

declare(strict_types=1);
chdir(__DIR__ . '/..');
if ($argc < 2) { echo "Usage: php restore_product_image.php <product_id>\n"; exit(1); }
$id = (int)$argv[1];
$csv = __DIR__ . '/backup_image_urls.csv';
if (!is_file($csv)) { echo "Backup CSV not found: $csv\n"; exit(1); }
$h = fopen($csv,'r');
$found = null;
while (($r = fgetcsv($h)) !== false) {
    if ((int)($r[0]) === $id) { $found = $r; break; }
}
fclose($h);
if (!$found) { echo "No backup entry for id=$id\n"; exit(1); }
$oldUrl = $found[2] ?? $found[1] ?? null;
if (!$oldUrl) { echo "No url found in backup for id=$id\n"; exit(1); }
$env = require __DIR__ . '/../App/Config/env.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $env['db_host'], $env['db_name']);
try { $pdo = new PDO($dsn, $env['db_user'], $env['db_pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch (PDOException $e) { echo "DB connect error: " . $e->getMessage() . PHP_EOL; exit(1); }

$stmt = $pdo->prepare('UPDATE products SET image_url = ? WHERE id = ?');
try {
    $stmt->execute([$oldUrl, $id]);
    echo "Restored product $id -> $oldUrl\n";
} catch (Exception $e) {
    echo "DB update failed: " . $e->getMessage() . PHP_EOL; exit(1);
}

// remove the invalid product copy if exists
$dstDir = __DIR__ . '/../Public/Assets/Images/products';
$files = glob($dstDir . '/product_' . $id . '_*');
foreach ($files as $f) {
    // only delete if filesize seems tiny or invalid image
    if (is_file($f) && filesize($f) < 200) { @unlink($f); }
}

?>