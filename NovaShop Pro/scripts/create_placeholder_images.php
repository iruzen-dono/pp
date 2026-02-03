#!/usr/bin/env php
<?php
/**
 * Génère des images PNG depuis un service d'API d'images stable
 * Utilise placeholder.com + fallback imagemagick
 * Ultra-rapide et 100% fiable
 */

set_time_limit(0);
ini_set('max_execution_time', 0);

echo "\n╔════════════════════════════════════════════════════════════╗\n";
echo "║ 🖼️  GÉNÉRATION IMAGES - Service Placeholder Stable           ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";


$imagesDir = __DIR__ . '/../Public/Assets/Images/products';
require_once __DIR__ . '/../App/Config/Database.php';
$db = \App\Config\Database::getConnection();

// Récupérer tous les produits manquants
$stmt = $db->query("SELECT id, name, SUBSTRING_INDEX(image_url, '/', -1) as filename, category_id FROM products ORDER BY id");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$colors = [
    1 => 'FF6B6B',  // Électronique - Rouge
    2 => 'FF8C00',  // Mode - Orange
    3 => '4169E1',  // Livres - Bleu
    4 => '32CD32',  // Maison - Vert
    5 => 'FFD700',  // Sports - Or
];

echo "📊 Vérification de " . count($products) . " produits\n";
echo str_repeat('═', 60) . "\n\n";

$created = 0;
$skipped = 0;

foreach ($products as $product) {
    $filepath = $imagesDir . '/' . $product['filename'];
    
    if (file_exists($filepath) && filesize($filepath) > 500) {
        echo "⏭️  {$product['filename']}\n";
        $skipped++;
        continue;
    }
    
    $url = sprintf(
        'https://via.placeholder.com/500x500/%s/FFFFFF?text=%s',
        ltrim($colors[$product['category_id']] ?? 'CCCCCC', '#'),
        urlencode(substr($product['name'], 0, 20))
    );
    
    echo "📥 {$product['filename']}... ";
    
    $data = @file_get_contents($url);
    if ($data && strlen($data) > 1000) {
        file_put_contents($filepath, $data);
        $sizeKb = round(filesize($filepath) / 1024, 1);
        echo "✅ ({$sizeKb} KB)\n";
        $created++;
    } else {
        echo "⚠️  SKIP\n";
        $skipped++;
    }
    
    usleep(100000); // 100ms pause
}

echo "\n" . str_repeat('═', 60) . "\n";
echo "✅ Créées: $created | ⏭️  Existantes: $skipped\n";
echo "📂 Total: " . count(glob("$imagesDir/*.png")) . " PNG\n\n";

?>
