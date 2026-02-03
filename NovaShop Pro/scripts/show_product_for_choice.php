<?php
// show_product_for_choice.php
// Usage: php show_product_for_choice.php <product_id>

declare(strict_types=1);
chdir(__DIR__ . '/..');
if ($argc < 2) {
    echo "Usage: php show_product_for_choice.php <product_id>\n";
    exit(1);
}
$productId = (int)$argv[1];

$env = require __DIR__ . '/../App/Config/env.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $env['db_host'], $env['db_name']);
try { $pdo = new PDO($dsn, $env['db_user'], $env['db_pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch (PDOException $e) { echo "DB connect error: " . $e->getMessage() . PHP_EOL; exit(1); }

$stmt = $pdo->prepare('SELECT id, name, description, image_url FROM products WHERE id = ?');
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
    echo "Product not found: $productId\n";
    exit(1);
}

echo "\n========== PRODUCT ID: $productId ==========\n";
echo "Name: " . $product['name'] . "\n";
echo "Description: " . substr($product['description'] ?? '', 0, 100) . "...\n";
echo "Current image: " . $product['image_url'] . "\n";
echo "\n========== TOP 5 CANDIDATE IMAGES ==========\n";

// read candidates.csv
$candidates = [];
if (is_file(__DIR__ . '/candidates.csv')) {
    $f = fopen(__DIR__ . '/candidates.csv', 'r');
    while ($row = fgetcsv($f)) {
        if (count($row) >= 3 && (int)$row[0] === $productId) {
            $candidates[] = ['filename' => $row[1], 'score' => (float)$row[2]];
        }
    }
    fclose($f);
}

if (count($candidates) === 0) {
    echo "No candidates found in candidates.csv\n";
} else {
    foreach ($candidates as $i => $c) {
        echo ($i+1) . ". " . $c['filename'] . " (score: " . round($c['score'], 3) . ")\n";
    }
}

echo "\n========== AVAILABLE SOURCE IMAGES IN image_php ==========\n";
$srcDir = __DIR__ . '/../Public/Assets/Images/image_php';
if (is_dir($srcDir)) {
    $files = array_diff(scandir($srcDir), ['.', '..']);
    echo "Total: " . count($files) . " images\n";
    echo "Type a filename to choose, or press Ctrl+C to skip.\n";
}
?>
