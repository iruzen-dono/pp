#!/usr/bin/env php
<?php
/**
 * Script de Téléchargement des Images Produits - v3 ROBUSTE
 * Récupère les noms depuis la BDD et télécharge les images PNG
 * Usage: php scripts/download_product_images.php
 */

set_time_limit(0); // Pas de limite
ini_set('max_execution_time', 0);

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   📸 TÉLÉCHARGEMENT IMAGES PRODUITS v3 - ROBUSTE           ║\n";
echo "║   Source: Unsplash + Fallback Placeholder                  ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Configuration
$imagesDir = __DIR__ . '/../Public/Assets/Images/products';
$retryMax = 3;

// Créer le répertoire
if (!is_dir($imagesDir)) {
    if (!@mkdir($imagesDir, 0755, true)) {
        die("❌ ERREUR: Impossible de créer $imagesDir\n");
    }
    echo "✅ Répertoire créé: $imagesDir\n\n";
}

// Connexion BDD via App\Config\Database
try {
    require_once __DIR__ . '/../App/Config/Database.php';
    $db = \App\Config\Database::getConnection();
} catch (Exception $e) {
    die("❌ ERREUR BDD: " . $e->getMessage() . "\n");
}

// Récupérer tous les produits avec URLs d'images
try {
    $stmt = $db->query("
        SELECT id, name, SUBSTRING_INDEX(image_url, '/', -1) as filename 
        FROM products 
        ORDER BY id
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    die("❌ ERREUR requête: " . $e->getMessage() . "\n");
}

if (empty($products)) {
    die("❌ ERREUR: Aucun produit trouvé en BDD\n");
}

echo "📊 Trouvé " . count($products) . " produits en BDD\n";
echo str_repeat('═', 60) . "\n\n";

// Mapping des images Unsplash de fallback (URLs stables)
$unsplashUrls = [
    // Électronique
    'macbook_pro.png'      => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop',
    'dell_xps.png'         => 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&h=500&fit=crop',
    'apple_watch.png'      => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop',
    'sony_headphones.png'  => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop',
    'lg_ultrawide.png'     => 'https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?w=500&h=500&fit=crop',
    'tablet.png'           => 'https://images.unsplash.com/photo-1552820728-8016266d5a27?w=500&h=500&fit=crop',
    'power_bank.png'       => 'https://images.unsplash.com/photo-1609042231671-bc09e37ddc74?w=500&h=500&fit=crop',
    
    // Mode
    'leather_jacket.png'   => 'https://images.unsplash.com/photo-1551028719-00167b16ebc5?w=500&h=500&fit=crop',
    'jeans.png'            => 'https://images.unsplash.com/photo-1542272604-787c62e32fc9?w=500&h=500&fit=crop',
    'shirt.png'            => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop',
    'sweater.png'          => 'https://images.unsplash.com/photo-1516762714899-e1fb3e0b5f17?w=500&h=500&fit=crop',
    'sneakers.png'         => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop',
    'watch.png'            => 'https://images.unsplash.com/photo-1523170335684-f1b5aef169d3?w=500&h=500&fit=crop',
    'sunglasses.png'       => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500&h=500&fit=crop',
    
    // Livres
    'clean_code.png'       => 'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop',
    'pragmatic.png'        => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&h=500&fit=crop',
    'design_patterns.png'  => 'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop',
    'atomic_habits.png'    => 'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop',
    'zero_to_one.png'      => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&h=500&fit=crop',
    'python_ds.png'        => 'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=500&fit=crop',
    'react_book.png'       => 'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop',
    
    // Maison
    'desk_lamp.png'        => 'https://images.unsplash.com/photo-1565636192335-14462d25de79?w=500&h=500&fit=crop',
    'artificial_plant.png' => 'https://images.unsplash.com/photo-1520763185298-1b434c919eba?w=500&h=500&fit=crop',
    'mirror.png'           => 'https://images.unsplash.com/photo-1578500494198-246f612d03b3?w=500&h=500&fit=crop',
    'gaming_chair.png'     => 'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500&h=500&fit=crop',
    'shelves.png'          => 'https://images.unsplash.com/photo-1467920591330-bea64389e7b0?w=500&h=500&fit=crop',
    'rug.png'              => 'https://images.unsplash.com/photo-1487033127519-95e86ddfcb4c?w=500&h=500&fit=crop',
    'bookshelf.png'        => 'https://images.unsplash.com/photo-1467920591330-bea64389e7b0?w=500&h=500&fit=crop',
    
    // Sports
    'gravel_bike.png'      => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop',
    'dumbbells.png'        => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&h=500&fit=crop',
    'yoga_mat.png'         => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=500&h=500&fit=crop',
    'garmin_watch.png'     => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop',
    'trail_shoes.png'      => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop',
    'backpack.png'         => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop',
    'kettlebell.png'       => 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&h=500&fit=crop',
];

$downloaded = 0;
$failed = 0;
$failures = [];

// Télécharger chaque image
foreach ($products as $product) {
    $filename = $product['filename'];
    $filepath = $imagesDir . '/' . $filename;
    $productName = $product['name'];
    
    // Vérifier si existe
    if (file_exists($filepath)) {
        echo "⏭️  {$filename} (OK - " . round(filesize($filepath) / 1024, 1) . " KB)\n";
        $downloaded++;
        continue;
    }
    
    // Récupérer URL
    $url = $unsplashUrls[$filename] ?? null;
    if (!$url) {
        echo "⚠️  {$filename} - URL NON TROUVÉE\n";
        $failed++;
        $failures[] = $filename;
        continue;
    }
    
    // Retry avec fallback
    $imageData = null;
    for ($attempt = 1; $attempt <= $retryMax; $attempt++) {
        echo "📥 {$filename} (tentative $attempt/$retryMax)... ";
        
        $context = stream_context_create([
            'http' => [
                'timeout' => 15,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'follow_location' => true,
                'max_redirects' => 5
            ]
        ]);
        
        $imageData = @file_get_contents($url, false, $context);
        
        if ($imageData !== false && strlen($imageData) > 1000) {
            // Valider que c'est une image
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_buffer($finfo, $imageData);
            finfo_close($finfo);
            
            if (strpos($mime, 'image') !== false) {
                break; // Succès!
            }
        }
        
        usleep(500000); // 0.5s avant retry
    }
    
    if ($imageData && strlen($imageData) > 1000) {
        if (file_put_contents($filepath, $imageData) !== false) {
            $sizeKb = round(filesize($filepath) / 1024, 1);
            echo "✅ ({$sizeKb} KB)\n";
            $downloaded++;
        } else {
            echo "❌ ERREUR ÉCRITURE\n";
            $failed++;
            $failures[] = $filename;
        }
    } else {
        echo "❌ TÉLÉCHARGEMENT ÉCHOUÉ\n";
        $failed++;
        $failures[] = $filename;
    }
}

// Résultats
echo "\n" . str_repeat('═', 60) . "\n";
echo "📊 RÉSULTATS FINAUX:\n";
echo "✅ Téléchargées: $downloaded / " . count($products) . "\n";
echo "❌ Échouées: $failed\n";

if (!empty($failures)) {
    echo "\n⚠️  Images manquantes:\n";
    foreach ($failures as $f) {
        echo "   • $f\n";
    }
}

// Lister les fichiers téléchargés
$files = scandir($imagesDir);
$imageFiles = array_filter($files, function($f) {
    return in_array(pathinfo($f, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
});

echo "\n📁 Total fichiers présents: " . count($imageFiles) . "\n";
echo "📂 Répertoire: $imagesDir\n\n";

?>
