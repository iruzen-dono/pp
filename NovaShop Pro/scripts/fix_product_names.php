<?php
// fix_product_names.php
// Fix UTF-8 encoding issues in product names

declare(strict_types=1);
chdir(__DIR__ . '/..');

$env = require __DIR__ . '/../App/Config/env.php';
$dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $env['db_host'], $env['db_name']);
try { $pdo = new PDO($dsn, $env['db_user'], $env['db_pass'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]); }
catch (PDOException $e) { echo "DB error: " . $e->getMessage() . PHP_EOL; exit(1); }

// Manual fixes for known corrupted names
$fixes = [
    9 => 'Jeans Slim Bleu Délavé',
    12 => 'Pull Laine Mérinos Gris',
    17 => 'Écharpe Soie Premium',
    28 => 'Miroir Mural Doré Octagonal',
    29 => 'Étagères Flottantes Design',
    32 => 'Vélo Gravel Premium',
];

echo "Fixing product names...\n";
foreach ($fixes as $id => $newName) {
    $stmt = $pdo->prepare('UPDATE products SET name = ? WHERE id = ?');
    try {
        $stmt->execute([$newName, $id]);
        echo "✓ Product $id: $newName\n";
    } catch (Exception $e) {
        echo "✗ Product $id: " . $e->getMessage() . PHP_EOL;
    }
}

echo "\nDone.\n";
?>
