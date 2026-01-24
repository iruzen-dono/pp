<?php
/**
 * Script de création des images produits
 * Génère des images PNG avec placeholder et texte
 */

$imagesDir = __DIR__ . '/../Public/Assets/Images/products';

// Créer le répertoire s'il n'existe pas
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
}

// Liste des images avec catégories
$images = [
    // Électronique
    'macbook_pro.png' => ['color' => [240, 248, 255], 'text' => 'MacBook Pro'],
    'wireless_headphones.png' => ['color' => [230, 230, 250], 'text' => 'Headphones'],
    'iphone_camera.png' => ['color' => [255, 250, 240], 'text' => 'iPhone 15'],
    'smartwatch.png' => ['color' => [245, 245, 245], 'text' => 'SmartWatch'],
    'mechanical_keyboard.png' => ['color' => [240, 255, 240], 'text' => 'Keyboard'],
    'gaming_mouse.png' => ['color' => [255, 240, 245], 'text' => 'Gaming Mouse'],
    'usb_hub.png' => ['color' => [255, 255, 240], 'text' => 'USB Hub'],
    'portable_charger.png' => ['color' => [240, 248, 255], 'text' => 'Charger'],
    'monitor_gaming.png' => ['color' => [245, 245, 245], 'text' => 'Monitor'],
    'tablet.png' => ['color' => [240, 255, 240], 'text' => 'Tablet'],
    
    // Mode & Vêtements
    'leather_jacket.png' => ['color' => [101, 67, 33], 'text' => 'Leather Jacket'],
    'designer_watch.png' => ['color' => [192, 192, 192], 'text' => 'Designer Watch'],
    'classic_jeans.png' => ['color' => [30, 58, 138], 'text' => 'Jeans'],
    'dress_elegant.png' => ['color' => [220, 20, 60], 'text' => 'Dress'],
    'sneakers_premium.png' => ['color' => [255, 255, 255], 'text' => 'Sneakers'],
    'sunglasses_style.png' => ['color' => [0, 0, 0], 'text' => 'Sunglasses'],
    'scarf_silk.png' => ['color' => [255, 182, 193], 'text' => 'Scarf'],
    
    // Livres & Publications
    'design_patterns.png' => ['color' => [139, 69, 19], 'text' => 'Design Patterns'],
    'clean_code.png' => ['color' => [47, 79, 79], 'text' => 'Clean Code'],
    'javascript_book.png' => ['color' => [240, 230, 200], 'text' => 'JavaScript'],
    'web_development.png' => ['color' => [119, 136, 153], 'text' => 'Web Dev'],
    'psychology_book.png' => ['color' => [176, 196, 222], 'text' => 'Psychology'],
    'business_strategy.png' => ['color' => [105, 105, 105], 'text' => 'Business'],
    
    // Maison & Décor
    'persian_rug.png' => ['color' => [160, 82, 45], 'text' => 'Persian Rug'],
    'modern_lamp.png' => ['color' => [255, 215, 0], 'text' => 'Lamp'],
    'designer_chair.png' => ['color' => [210, 180, 140], 'text' => 'Chair'],
    'table_marble.png' => ['color' => [211, 211, 211], 'text' => 'Marble Table'],
    'wooden_shelves.png' => ['color' => [139, 90, 43], 'text' => 'Shelves'],
    'decorative_mirror.png' => ['color' => [192, 192, 192], 'text' => 'Mirror'],
    
    // Sports & Fitness
    'gravel_bike.png' => ['color' => [178, 34, 34], 'text' => 'Gravel Bike'],
    'tennis_racket.png' => ['color' => [34, 139, 34], 'text' => 'Tennis'],
    'yoga_mat.png' => ['color' => [255, 192, 203], 'text' => 'Yoga Mat'],
    'dumbbells_set.png' => ['color' => [105, 105, 105], 'text' => 'Dumbbells'],
    'running_shoes.png' => ['color' => [255, 140, 0], 'text' => 'Running Shoes'],
    'football_ball.png' => ['color' => [34, 139, 34], 'text' => 'Football'],
];

echo "\n📸 CRÉATION DES IMAGES PRODUITS\n";
echo str_repeat('═', 50) . "\n\n";

$created = 0;
$failed = 0;

foreach ($images as $filename => $data) {
    $filepath = $imagesDir . '/' . $filename;
    
    // Vérifier si l'image existe
    if (file_exists($filepath)) {
        echo "⏭️  $filename (déjà existant)\n";
        $created++;
        continue;
    }
    
    // Créer l'image
    $image = imagecreatetruecolor(500, 500);
    $color = imagecolorallocate($image, $data['color'][0], $data['color'][1], $data['color'][2]);
    imagefilledrectangle($image, 0, 0, 500, 500, $color);
    
    // Ajouter le texte
    $textColor = imagecolorallocate($image, 255, 255, 255);
    if ($data['color'][0] + $data['color'][1] + $data['color'][2] > 382) {
        $textColor = imagecolorallocate($image, 0, 0, 0);
    }
    
    $text = $data['text'];
    $fontSize = 5;
    $fontWidth = imagefontwidth($fontSize);
    $fontHeight = imagefontheight($fontSize);
    
    $x = (500 - (strlen($text) * $fontWidth)) / 2;
    $y = (500 - $fontHeight) / 2;
    
    imagestring($image, $fontSize, $x, $y, $text, $textColor);
    
    // Sauvegarder l'image
    if (imagepng($image, $filepath)) {
        echo "✅ $filename\n";
        $created++;
    } else {
        echo "❌ $filename (Erreur d'écriture)\n";
        $failed++;
    }
    
    imagedestroy($image);
}

echo "\n" . str_repeat('═', 50) . "\n";
echo "📊 RÉSULTATS:\n";
echo "✅ Créées: $created\n";
echo "❌ Échouées: $failed\n";
echo "📁 Répertoire: $imagesDir\n\n";

// Vérifier les fichiers
$files = array_diff(scandir($imagesDir), ['.', '..']);
echo "🖼️  Images disponibles: " . count($files) . "\n\n";

?>
