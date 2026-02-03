<?php
/**
 * Script de Téléchargement des Images Produits
 * Télécharge les images depuis Unsplash avec retry automatique
 * Usage: php scripts/download_product_images.php
 */

set_time_limit(600); // 10 minutes timeout

echo "\n";
echo "╔═════════════════════════════════════════════════════════════╗\n";
echo "║   📸 TÉLÉCHARGEMENT DES IMAGES PRODUITS (v2.0)              ║\n";
echo "╚═════════════════════════════════════════════════════════════╝\n\n";

// Configuration
$imagesDir = __DIR__ . '/../Public/Assets/Images/products';
$retryMax = 3; // Nombre de tentatives par image

// Créer le répertoire s'il n'existe pas
if (!is_dir($imagesDir)) {
    if (!@mkdir($imagesDir, 0755, true)) {
        die("❌ ERREUR: Impossible de créer le répertoire $imagesDir\n");
    }
    echo "✅ Répertoire créé: $imagesDir\n\n";
}

// Liste des images avec URLs de fallback (primary + backup)
$images = [
    // Électronique
    'macbook_pro.jpg' => [
        'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&q=80',
        'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&q=80',
    ],
    'wireless_headphones.jpg' => [
        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&q=80',
        'https://images.unsplash.com/photo-1487215078519-e21cc028cb29?w=500&q=80',
    ],
    'tablet.jpg' => [
        'https://images.unsplash.com/photo-1552820728-8016266d5a27?w=500&q=80',
        'https://images.unsplash.com/photo-1580522539313-552107fabf5b?w=500&q=80',
    ],
    'portable_charger.jpg' => [
        'https://images.unsplash.com/photo-1609042231671-bc09e37ddc74?w=500&q=80',
        'https://images.unsplash.com/photo-1591290621749-2127ba37f058?w=500&q=80',
    ],
    'smartwatch.jpg' => [
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80',
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80',
    ],
    'gaming_mouse.jpg' => [
        'https://images.unsplash.com/photo-1527814050087-3793815479db?w=500&q=80',
        'https://images.unsplash.com/photo-1527814050087-3793815479db?w=500&q=80',
    ],
    'usb_hub.jpg' => [
        'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=500&q=80',
        'https://images.unsplash.com/photo-1597872200969-2b65d56bd16b?w=500&q=80',
    ],
    'monitor_gaming.jpg' => [
        'https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?w=500&q=80',
        'https://images.unsplash.com/photo-1527814050087-3793815479db?w=500&q=80',
    ],
    
    // Mode & Vêtements
    'leather_jacket.jpg' => [
        'https://images.unsplash.com/photo-1551028719-00167b16ebc5?w=500&q=80',
        'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&q=80',
    ],
    'classic_jeans.jpg' => [
        'https://images.unsplash.com/photo-1542272604-787c62e32fc9?w=500&q=80',
        'https://images.unsplash.com/photo-1542272604-787c62e32fc9?w=500&q=80',
    ],
    'dress_elegant.jpg' => [
        'https://images.unsplash.com/photo-1589749235044-85a37490e46a?w=500&q=80',
        'https://images.unsplash.com/photo-1545887917-b2dee8428efb?w=500&q=80',
    ],
    'sneakers_premium.jpg' => [
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&q=80',
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&q=80',
    ],
    'designer_watch.jpg' => [
        'https://images.unsplash.com/photo-1523170335684-f1b5aef169d3?w=500&q=80',
        'https://images.unsplash.com/photo-1523170335684-f1b5aef169d3?w=500&q=80',
    ],
    'sunglasses_style.jpg' => [
        'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500&q=80',
        'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500&q=80',
    ],
    'scarf_silk.jpg' => [
        'https://images.unsplash.com/photo-1599203166276-c41e15d45adb?w=500&q=80',
        'https://images.unsplash.com/photo-1599203166276-c41e15d45adb?w=500&q=80',
    ],
    'running_shoes.jpg' => [
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&q=80',
        'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?w=500&q=80',
    ],
    
    // Livres
    'design_patterns.jpg' => [
        'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&q=80',
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&q=80',
    ],
    'clean_code.jpg' => [
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&q=80',
        'https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=500&q=80',
    ],
    'web_development.jpg' => [
        'https://images.unsplash.com/photo-1633356122544-f134324ef6db?w=500&q=80',
        'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&q=80',
    ],
    'javascript_book.jpg' => [
        'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&q=80',
        'https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=500&q=80',
    ],
    'psychology_book.jpg' => [
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&q=80',
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&q=80',
    ],
    'business_strategy.jpg' => [
        'https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&q=80',
        'https://images.unsplash.com/photo-1552664730-d307ca884978?w=500&q=80',
    ],
    
    // Maison & Décor
    'modern_lamp.jpg' => [
        'https://images.unsplash.com/photo-1565636192335-14c46fa15602?w=500&q=80',
        'https://images.unsplash.com/photo-1543269865-cbf427effbad?w=500&q=80',
    ],
    'decorative_mirror.jpg' => [
        'https://images.unsplash.com/photo-1576228104129-a2d3e75f3ded?w=500&q=80',
        'https://images.unsplash.com/photo-1578926078328-123e987b1bca?w=500&q=80',
    ],
    'designer_chair.jpg' => [
        'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&q=80',
        'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&q=80',
    ],
    'persian_rug.jpg' => [
        'https://images.unsplash.com/photo-1571733280207-d56e6a79a7e2?w=500&q=80',
        'https://images.unsplash.com/photo-1578926078328-123e987b1bca?w=500&q=80',
    ],
    
    // Sports
    'gravel_bike.jpg' => [
        'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&q=80',
        'https://images.unsplash.com/photo-1492684223066-81342ee5ff30?w=500&q=80',
    ],
    'dumbbells_set.jpg' => [
        'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&q=80',
        'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&q=80',
    ],
    'yoga_mat.jpg' => [
        'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=500&q=80',
        'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=500&q=80',
    ],
];

// Fonction de téléchargement avec retry
function downloadImage($urls, $filepath, $filename, $retryMax) {
    $successCount = 0;
    $failCount = 0;
    
    foreach ($urls as $attempt => $imageUrl) {
        $imageData = @file_get_contents($imageUrl, false, stream_context_create([
            'http' => [
                'timeout' => 15,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'follow_location' => 1,
                'max_redirects' => 5,
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
            ]
        ]));
        
        if ($imageData !== false && strlen($imageData) > 1000) {
            if (@file_put_contents($filepath, $imageData)) {
                echo "✅ OK (" . filesize($filepath) . " bytes)\n";
                return true;
            }
        }
    }
    
    echo "❌ ÉCHEC\n";
    return false;
}

// Télécharger les images
$successCount = 0;
$failCount = 0;
$skipCount = 0;

echo "Téléchargement avec retry automatique...\n";
echo str_repeat("-", 60) . "\n";

foreach ($images as $filename => $urls) {
    $filepath = $imagesDir . '/' . $filename;
    
    // Vérifier si le fichier existe déjà
    if (file_exists($filepath)) {
        echo "⏭️  EXISTE : $filename (" . filesize($filepath) . " bytes)\n";
        $skipCount++;
        continue;
    }
    
    // Télécharger l'image
    echo "📥 Téléchargement: $filename ... ";
    
    if (downloadImage($urls, $filepath, $filename, $retryMax)) {
        $successCount++;
    } else {
        $failCount++;
    }
    
    // Rate limiting
    usleep(200000); // 200ms
}

// Résumé
echo "\n" . str_repeat("-", 60) . "\n";
echo "📊 RÉSUMÉ DU TÉLÉCHARGEMENT\n";
echo str_repeat("-", 60) . "\n";
echo "✅ Succès: $successCount images\n";
echo "⏭️  Existantes: $skipCount images\n";
echo "❌ Erreurs: $failCount images\n";
echo "📁 Dossier: $imagesDir\n";
echo str_repeat("-", 60) . "\n\n";

// Vérifier le total
$totalFiles = count(glob($imagesDir . '/*.{jpg,jpeg,png}', GLOB_BRACE));
echo "🖼️  Total des images disponibles: $totalFiles\n\n";

if ($failCount > 0) {
    echo "⚠️  $failCount images n'ont pas pu être téléchargées.\n";
    echo "   Exécutez la génération PNG de fallback:\n";
    echo "   php scripts/generate_images.php\n\n";
}

if ($successCount + $skipCount > 0) {
    echo "✅ Téléchargement terminé!\n";
}

exit(0);
?>
echo "🖼️  Total des images disponibles: $totalFiles\n\n";

if ($failCount > 0) {
    echo "⚠️  Attention: Certaines images n'ont pas pu être téléchargées.\n";
    echo "   Vous pouvez télécharger manuellement les images ou utiliser\n";
    echo "   les images PNG de fallback qui existent déjà.\n\n";
}

echo "✅ Téléchargement des images terminé!\n";
echo "Les images sont disponibles dans: /Public/Assets/Images/products/\n\n";

exit(0);
?>

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
