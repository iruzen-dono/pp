#!/usr/bin/env php
<?php
$db = new PDO('mysql:host=localhost;dbname=novashop', 'root', '0000');
$stmt = $db->query('SELECT DISTINCT SUBSTRING_INDEX(image_url, "/", -1) as f FROM products ORDER BY f');
$needed = array_column($stmt->fetchAll(), 'f');

$dir = './Public/Assets/Images/products';
$existing = [];

foreach (scandir($dir) as $file) {
    $path = $dir . '/' . $file;
    if (is_file($path) && filesize($path) > 100) {
        $existing[] = $file;
    }
}

$missing = array_diff($needed, $existing);

echo "Nécessaires: " . count($needed) . "\n";
echo "Existantes (>100 bytes): " . count($existing) . "\n";
echo "Manquantes: " . count($missing) . "\n";

if (count($missing) > 0) {
    echo "\nImages manquantes:\n";
    foreach ($missing as $m) {
        echo "  • $m\n";
    }
}
?>
