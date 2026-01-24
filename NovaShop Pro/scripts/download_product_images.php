<?php
/**
 * Script de téléchargement des images produits
 * Télécharge les images Unsplash et les stocke localement
 */

// Configuration
$imagesDir = __DIR__ . '/../Public/Assets/Images/products';
$baseUrl = 'https://images.unsplash.com/photo-';

// Créer le répertoire s'il n'existe pas
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
    echo "✅ Répertoire créé: $imagesDir\n";
}

// Liste des images avec leurs IDs Unsplash et noms
$images = [
    // Électronique (10)
    ['id' => '1555597140157-7b5f9c5e2f5b', 'name' => 'macbook_pro.jpg'],
    ['id' => '1505228395891-9a180e76d7c7', 'name' => 'wireless_headphones.jpg'],
    ['id' => '1505999407962-9deb6507127f', 'name' => 'iphone_camera.jpg'],
    ['id' => '1526170375885-4d8ecf77b99f', 'name' => 'smartwatch.jpg'],
    ['id' => '1609042231671-bc09e37ddc74', 'name' => 'mechanical_keyboard.jpg'],
    ['id' => '1567450489212-d37b5ba1b639', 'name' => 'gaming_mouse.jpg'],
    ['id' => '1600432063322-8b60f8f0c663', 'name' => 'usb_hub.jpg'],
    ['id' => '1609042231671-bc09e37ddc74', 'name' => 'portable_charger.jpg'],
    ['id' => '1519389950473-47ba0277781c', 'name' => 'monitor_gaming.jpg'],
    ['id' => '1523275335684-37898b6baf30', 'name' => 'tablet.jpg'],
    
    // Mode & Vêtements (7)
    ['id' => '1521572163474-6864f9cf17ab', 'name' => 'leather_jacket.jpg'],
    ['id' => '1539533057671-4914f2dc9fb3', 'name' => 'designer_watch.jpg'],
    ['id' => '1572635196237-14b3f281503f', 'name' => 'classic_jeans.jpg'],
    ['id' => '1598103442097-8b74394b95c6', 'name' => 'dress_elegant.jpg'],
    ['id' => '1542272604-787c62e32fc9', 'name' => 'sneakers_premium.jpg'],
    ['id' => '1491553895911-0055eca6402d', 'name' => 'sunglasses_style.jpg'],
    ['id' => '1599203166276-c41e15d45adb', 'name' => 'scarf_silk.jpg'],
    
    // Livres & Publications (6)
    ['id' => '1507842591343-583f20051fa3', 'name' => 'design_patterns.jpg'],
    ['id' => '1507842591343-583f20051fa3', 'name' => 'clean_code.jpg'],
    ['id' => '1506880018603-83d5b814b5a6', 'name' => 'javascript_book.jpg'],
    ['id' => '1495446815901-a7297e1bfef5', 'name' => 'web_development.jpg'],
    ['id' => '1543002588-d0a6c3fbf763', 'name' => 'psychology_book.jpg'],
    ['id' => '1524995997946-a1c2e315a42f', 'name' => 'business_strategy.jpg'],
    
    // Maison & Décor (6)
    ['id' => '1555041469-a586c61ea9bc', 'name' => 'persian_rug.jpg'],
    ['id' => '1594736797933-d0501ba2fe65', 'name' => 'modern_lamp.jpg'],
    ['id' => '1578749556568-bc2c40e0b254', 'name' => 'designer_chair.jpg'],
    ['id' => '1556909114-f6e7ad7d3136', 'name' => 'table_marble.jpg'],
    ['id' => '1578500494198-246f612d9ae0', 'name' => 'wooden_shelves.jpg'],
    ['id' => '1578500494198-246f612d9ae0', 'name' => 'decorative_mirror.jpg'],
    
    // Sports & Fitness (6)
    ['id' => '1558618666-fcd25c85cd64', 'name' => 'gravel_bike.jpg'],
    ['id' => '1542291026-7eec264c27ff', 'name' => 'tennis_racket.jpg'],
    ['id' => '1523438097911-512ec2a62abb', 'name' => 'yoga_mat.jpg'],
    ['id' => '1534438327276-14e5300c3eca', 'name' => 'dumbbells_set.jpg'],
    ['id' => '1574821541239-20bfe71e4cc6', 'name' => 'running_shoes.jpg'],
    ['id' => '1542291026-7eec264c27ff', 'name' => 'football_ball.jpg'],
];

echo "\n🖼️  TÉLÉCHARGEMENT DES IMAGES PRODUITS\n";
echo str_repeat('═', 50) . "\n\n";

$downloaded = 0;
$failed = 0;

foreach ($images as $index => $image) {
    $url = $baseUrl . $image['id'] . '?w=500&h=500&fit=crop';
    $filepath = $imagesDir . '/' . $image['name'];
    
    // Vérifier si l'image existe déjà
    if (file_exists($filepath)) {
        echo "⏭️  {$image['name']} (déjà existant)\n";
        $downloaded++;
        continue;
    }
    
    // Télécharger l'image
    echo "📥 Téléchargement {$image['name']}... ";
    
    try {
        $imageData = @file_get_contents($url, false, stream_context_create([
            'http' => [
                'timeout' => 10,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36'
            ]
        ]));
        
        if ($imageData === false) {
            echo "❌ Erreur de téléchargement\n";
            $failed++;
            continue;
        }
        
        // Sauvegarder l'image
        if (file_put_contents($filepath, $imageData) !== false) {
            echo "✅\n";
            $downloaded++;
        } else {
            echo "❌ Erreur d'écriture\n";
            $failed++;
        }
    } catch (Exception $e) {
        echo "❌ " . $e->getMessage() . "\n";
        $failed++;
    }
    
    // Petit délai pour ne pas surcharger Unsplash
    usleep(500000); // 0.5 seconde
}

echo "\n" . str_repeat('═', 50) . "\n";
echo "📊 RÉSULTATS:\n";
echo "✅ Téléchargées: $downloaded\n";
echo "❌ Échouées: $failed\n";
echo "📁 Répertoire: $imagesDir\n\n";

// Afficher la liste des images téléchargées
$files = scandir($imagesDir);
$imageFiles = array_filter($files, function($f) {
    return in_array(pathinfo($f, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']);
});

if (!empty($imageFiles)) {
    echo "🖼️  Images téléchargées:\n";
    foreach ($imageFiles as $file) {
        $size = filesize($imagesDir . '/' . $file);
        $sizeKb = round($size / 1024, 1);
        echo "   • $file ($sizeKb KB)\n";
    }
}

echo "\n";
?>
