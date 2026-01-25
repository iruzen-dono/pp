<?php
/**
 * Script Créateur d'Images PNG Placeholder
 * Crée des images PNG colorées et nommées pour les produits
 * Utilise si Unsplash ne peut pas être téléchargé
 * Usage: php scripts/create_product_images.php
 */

set_time_limit(120);

echo "\n";
echo "╔═════════════════════════════════════════════════════════════╗\n";
echo "║   🖼️  CRÉATION DES IMAGES PLACEHOLDER PNG                   ║\n";
echo "╚═════════════════════════════════════════════════════════════╝\n\n";

$imagesDir = __DIR__ . '/../Public/Assets/Images/products';

// Créer le répertoire
if (!is_dir($imagesDir)) {
    if (!@mkdir($imagesDir, 0755, true)) {
        die("❌ ERREUR: Impossible de créer $imagesDir\n");
    }
    echo "✅ Répertoire créé\n\n";
}

// Couleurs pour les catégories
$colors = [
    'macbook' => [100, 150, 200],
    'wireless' => [255, 100, 100],
    'tablet' => [100, 200, 150],
    'portable' => [200, 150, 100],
    'smartwatch' => [150, 100, 200],
    'gaming' => [100, 200, 200],
    'usb' => [200, 200, 100],
    'monitor' => [100, 100, 200],
    'leather' => [139, 69, 19],
    'classic' => [70, 130, 180],
    'dress' => [255, 182, 193],
    'sneakers' => [255, 255, 255],
    'designer' => [184, 134, 11],
    'sunglasses' => [0, 0, 0],
    'scarf' => [255, 192, 203],
    'running' => [255, 215, 0],
    'design' => [70, 130, 180],
    'clean' => [192, 192, 192],
    'web' => [255, 165, 0],
    'javascript' => [240, 230, 45],
    'psychology' => [220, 20, 60],
    'business' => [34, 139, 34],
    'modern' => [255, 215, 0],
    'decorative' => [198, 226, 255],
    'designer_chair' => [205, 92, 92],
    'persian' => [139, 69, 19],
    'gravel' => [101, 67, 33],
    'dumbbells' => [178, 34, 34],
    'yoga' => [144, 238, 144],
];

// Liste des fichiers à créer
$imagesToCreate = [
    'macbook_pro.png' => [100, 150, 200],
    'wireless_headphones.png' => [255, 100, 100],
    'tablet.png' => [100, 200, 150],
    'portable_charger.png' => [200, 150, 100],
    'smartwatch.png' => [150, 100, 200],
    'gaming_mouse.png' => [100, 200, 200],
    'usb_hub.png' => [200, 200, 100],
    'monitor_gaming.png' => [100, 100, 200],
    'leather_jacket.png' => [139, 69, 19],
    'classic_jeans.png' => [70, 130, 180],
    'dress_elegant.png' => [255, 182, 193],
    'sneakers_premium.png' => [255, 255, 255],
    'designer_watch.png' => [184, 134, 11],
    'sunglasses_style.png' => [0, 0, 0],
    'scarf_silk.png' => [255, 192, 203],
    'running_shoes.png' => [255, 215, 0],
    'design_patterns.png' => [70, 130, 180],
    'clean_code.png' => [192, 192, 192],
    'web_development.png' => [255, 165, 0],
    'javascript_book.png' => [240, 230, 45],
    'psychology_book.png' => [220, 20, 60],
    'business_strategy.png' => [34, 139, 34],
    'modern_lamp.png' => [255, 215, 0],
    'decorative_mirror.png' => [198, 226, 255],
    'designer_chair.png' => [205, 92, 92],
    'persian_rug.png' => [139, 69, 19],
    'gravel_bike.png' => [101, 67, 33],
    'dumbbells_set.png' => [178, 34, 34],
    'yoga_mat.png' => [144, 238, 144],
];

// Ajouter produits générés
for ($i = 1; $i <= 35; $i++) {
    $name = 'product_' . str_pad($i, 3, '0', STR_PAD_LEFT) . '.png';
    $r = rand(50, 255);
    $g = rand(50, 255);
    $b = rand(50, 255);
    $imagesToCreate[$name] = [$r, $g, $b];
}

$successCount = 0;
$skipCount = 0;

echo "Création des images PNG:\n";
echo str_repeat("-", 60) . "\n";

foreach ($imagesToCreate as $filename => $rgb) {
    $filepath = $imagesDir . '/' . $filename;
    
    if (file_exists($filepath)) {
        echo "⏭️  EXISTE : $filename\n";
        $skipCount++;
        continue;
    }
    
    // Créer une image PNG simple avec la couleur
    $image = @imagecreatetruecolor(500, 500);
    if ($image === false) {
        echo "❌ ERREUR: $filename (imagecreatetruecolor échouée)\n";
        continue;
    }
    
    $color = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
    imagefilledrectangle($image, 0, 0, 500, 500, $color);
    
    // Ajouter du texte
    $textColor = imagecolorallocate($image, 255, 255, 255);
    imagestring($image, 5, 150, 230, strtoupper($filename), $textColor);
    
    // Sauvegarder
    if (@imagepng($image, $filepath)) {
        echo "✅ CRÉÉE : $filename (" . filesize($filepath) . " bytes)\n";
        $successCount++;
        imagedestroy($image);
    } else {
        echo "❌ ERREUR d'écriture: $filename\n";
        imagedestroy($image);
    }
}

echo "\n" . str_repeat("-", 60) . "\n";
echo "📊 RÉSUMÉ\n";
echo str_repeat("-", 60) . "\n";
echo "✅ Images créées: $successCount\n";
echo "⏭️  Images existantes: $skipCount\n";
echo "📁 Chemin: $imagesDir\n\n";

$totalFiles = count(glob($imagesDir . '/*.png'));
echo "🖼️  Total PNG disponibles: $totalFiles\n\n";

echo "✅ Création d'images terminée!\n\n";

exit(0);
?>
