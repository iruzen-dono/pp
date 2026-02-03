<?php
// analyze_image_mismatches.php
// Identify products where image filename doesn't match product name/description

declare(strict_types=1);
chdir(__DIR__ . '/..');

$env = require __DIR__ . '/../App/Config/env.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $env['db_host'], $env['db_name']);
try { $pdo = new PDO($dsn, $env['db_user'], $env['db_pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch (PDOException $e) { echo "DB error: " . $e->getMessage() . PHP_EOL; exit(1); }

$stmt = $pdo->prepare('SELECT id, name, image_url FROM products ORDER BY id');
$stmt->execute();
$products = $stmt->fetchAll();

echo "=== ANALYZING IMAGE/PRODUCT MISMATCHES ===\n\n";

$mismatches = [];
foreach ($products as $p) {
    $img_url = $p['image_url'];
    $prod_name = $p['name'];
    
    // extract filename from URL
    $img_filename = basename($img_url);
    
    // normalize both for comparison
    $norm_name = mb_strtolower(preg_replace('/[^a-z0-9]+/', ' ', $prod_name));
    $norm_img = mb_strtolower(preg_replace('/[^a-z0-9]+/', ' ', $img_filename));
    
    // simple heuristic: if no word from product name appears in image name, flag it
    $name_words = explode(' ', trim($norm_name));
    $found_match = false;
    foreach ($name_words as $word) {
        if (strlen($word) > 3 && strpos($norm_img, $word) !== false) {
            $found_match = true;
            break;
        }
    }
    
    if (!$found_match && strlen($norm_name) > 0) {
        $mismatches[] = [
            'id' => $p['id'],
            'name' => $prod_name,
            'image' => $img_filename
        ];
    }
}

if (count($mismatches) === 0) {
    echo "No obvious mismatches found.\n";
} else {
    echo "Found " . count($mismatches) . " potential mismatches:\n\n";
    foreach ($mismatches as $m) {
        echo $m['id'] . ". " . $m['name'] . "\n";
        echo "   Current image: " . $m['image'] . "\n\n";
    }
}

?>
