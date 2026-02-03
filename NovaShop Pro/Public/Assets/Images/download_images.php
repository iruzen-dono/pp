<?php
/**
 * Script de téléchargement des images produits
 * Utilise LoremFlickr pour télécharger des images pertinentes
 * Compatible avec Windows et Linux
 */

set_time_limit(300);
ini_set('display_errors', 1);

echo "\n═══════════════════════════════════════════════════════════\n";
echo "📥 Téléchargement des Images Produits (35 photos)\n";
echo "═══════════════════════════════════════════════════════════\n\n";

$productsDir = __DIR__ . '/products/';

// Créer le dossier s'il n'existe pas
if (!is_dir($productsDir)) {
    mkdir($productsDir, 0755, true);
    echo "✅ Dossier créé: $productsDir\n\n";
}

// 35 produits avec leurs mots-clés pour images pertinentes
$products = [
    // Électronique (8)
    1 => 'headphones', 2 => 'smartphone', 3 => 'gaming laptop', 4 => 'smartwatch',
    5 => 'tablet', 6 => 'camera', 7 => 'speaker', 8 => 'usb hub',
    // Mode (8)
    9 => 'leather jacket', 10 => 'sunglasses', 11 => 'jeans', 12 => 'dress',
    13 => 'sneakers', 14 => 'sweater', 15 => 't-shirt', 16 => 'scarf',
    // Livres (8)
    17 => 'science book', 18 => 'programming book', 19 => 'art history', 20 => 'cooking',
    21 => 'business strategy', 22 => 'fantasy novel', 23 => 'photography', 24 => 'design',
    // Maison (8)
    25 => 'sofa', 26 => 'dining table', 27 => 'lamp', 28 => 'kitchen',
    29 => 'bed frame', 30 => 'wall art', 31 => 'outdoor rug', 32 => 'plant pot',
    // Sports (3)
    33 => 'mountain bike', 34 => 'yoga mat', 35 => 'running shoes'
];

$successCount = 0;
$failCount = 0;

foreach ($products as $id => $keyword) {
    $filename = "product_" . str_pad($id, 3, '0', STR_PAD_LEFT) . ".jpg";
    $filepath = $productsDir . $filename;
    
    // Vérifier si l'image existe déjà
    if (file_exists($filepath) && filesize($filepath) > 1000) {
        echo "✅ [" . str_pad($id, 2, '0', STR_PAD_LEFT) . "/35] $filename (déjà existant)\n";
        $successCount++;
        continue;
    }
    
    // Construire l'URL LoremFlickr
    $url = "https://loremflickr.com/400/400/" . urlencode($keyword);
    
    try {
        $imageData = @file_get_contents($url, false, stream_context_create([
            'http' => ['timeout' => 10],
            'https' => ['timeout' => 10]
        ]));
        
        if ($imageData && strlen($imageData) > 1000) {
            if (file_put_contents($filepath, $imageData)) {
                echo "✅ [" . str_pad($id, 2, '0', STR_PAD_LEFT) . "/35] $filename (" . round(strlen($imageData)/1024, 1) . "KB)\n";
                $successCount++;
            } else {
                echo "❌ [" . str_pad($id, 2, '0', STR_PAD_LEFT) . "/35] $filename - Erreur d'écriture\n";
                $failCount++;
            }
        } else {
            echo "⚠️  [" . str_pad($id, 2, '0', STR_PAD_LEFT) . "/35] $filename - Image invalide\n";
            $failCount++;
        }
    } catch (Exception $e) {
        echo "❌ [" . str_pad($id, 2, '0', STR_PAD_LEFT) . "/35] $filename - Erreur: " . $e->getMessage() . "\n";
        $failCount++;
    }
    
    // Pause pour éviter les blocages
    usleep(500000);
}

echo "\n═══════════════════════════════════════════════════════════\n";
echo "📊 Résultats:\n";
echo "   ✅ Succès: $successCount/35\n";
echo "   ❌ Erreurs: $failCount/35\n";
echo "═══════════════════════════════════════════════════════════\n\n";

if ($successCount === 35) {
    echo "✨ Toutes les images ont été téléchargées avec succès!\n\n";
    exit(0);
} elseif ($successCount >= 30) {
    echo "✅ Téléchargement terminé avec succès (90%+ complété)\n\n";
    exit(0);
} else {
    echo "⚠️  Téléchargement partiel - Vérifiez votre connexion internet\n\n";
    exit(1);
}
