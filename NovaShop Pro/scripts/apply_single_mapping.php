<?php
// apply_single_mapping.php
// Usage: php apply_single_mapping.php <product_id> <source_filename>

declare(strict_types=1);
chdir(__DIR__ . '/..');
if ($argc < 3) {
    echo "Usage: php apply_single_mapping.php <product_id> <source_filename>\n";
    exit(1);
}
$productId = (int)$argv[1];
$sourceFile = $argv[2];

$env = require __DIR__ . '/../App/Config/env.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $env['db_host'], $env['db_name']);
try { $pdo = new PDO($dsn, $env['db_user'], $env['db_pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch (PDOException $e) { echo "DB connect error: " . $e->getMessage() . PHP_EOL; exit(1); }

$srcDir = __DIR__ . '/../Public/Assets/Images/image';
$dstDir = __DIR__ . '/../Public/Assets/Images/products';
if (!is_dir($dstDir)) mkdir($dstDir, 0755, true);

$srcPath = $srcDir . '/' . $sourceFile;
if (!is_file($srcPath)) { echo "Source file not found: $srcPath\n"; exit(1); }

// normalize name
function normalize(string $s): string {
    $s = mb_strtolower($s);
    $s = iconv('UTF-8','ASCII//TRANSLIT',$s);
    $s = preg_replace('/[^a-z0-9]+/','_', $s);
    $s = preg_replace('/_+/', '_', $s);
    return trim($s, '_');
}

$ext = pathinfo($sourceFile, PATHINFO_EXTENSION);
$base = pathinfo($sourceFile, PATHINFO_FILENAME);
$safe = normalize($base);
$dstName = 'product_' . $productId . '_' . $safe . '.' . $ext;
$dstPath = $dstDir . '/' . $dstName;

if (!copy($srcPath, $dstPath)) { echo "Failed to copy $srcPath -> $dstPath\n"; exit(1); }

$newUrl = '/Assets/Images/products/' . $dstName;
$stmt = $pdo->prepare('UPDATE products SET image_url = ? WHERE id = ?');
try {
    $stmt->execute([$newUrl, $productId]);
    echo "Updated product $productId -> $newUrl\n";
} catch (Exception $e) {
    echo "DB update failed: " . $e->getMessage() . PHP_EOL;
    // try to remove copied file
    @unlink($dstPath);
    exit(1);
}

// append to applied mappings log
$log = __DIR__ . '/applied_mappings.log';
file_put_contents($log, date('c') . "\t$productId\t$sourceFile\t$newUrl\n", FILE_APPEND);

?>
