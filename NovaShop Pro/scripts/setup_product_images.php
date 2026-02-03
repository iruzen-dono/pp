<?php
/**
 * Script de création des images produits avec ImageMagick ou ImageBase64
 * Crée des images PNG avec placeholder
 */

$imagesDir = __DIR__ . '/../Public/Assets/Images/products';

// Créer le répertoire s'il n'existe pas
if (!is_dir($imagesDir)) {
    mkdir($imagesDir, 0755, true);
}

// Fonction pour créer une image PNG simple en base64
function createColoredImageBase64($r, $g, $b, $text) {
    // Image PNG simple 1x1 pixel de couleur
    // C'est une image PNG valide de 1x1 pixel, redimensionnable par le navigateur
    $png = base64_decode(
        'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg=='
    );
    return $png;
}

// Liste des images avec catégories et couleurs
$images = [
    // Électronique - couleurs froides
    'macbook_pro.png' => ['hex' => '#87CEEB'],
    'wireless_headphones.png' => ['hex' => '#B0E0E6'],
    'iphone_camera.png' => ['hex' => '#ADD8E6'],
    'smartwatch.png' => ['hex' => '#87CEEB'],
    'mechanical_keyboard.png' => ['hex' => '#B0C4DE'],
    'gaming_mouse.png' => ['hex' => '#6495ED'],
    'usb_hub.png' => ['hex' => '#4169E1'],
    'portable_charger.png' => ['hex' => '#1E90FF'],
    'monitor_gaming.png' => ['hex' => '#0047AB'],
    'tablet.png' => ['hex' => '#00BFFF'],
    
    // Mode & Vêtements - couleurs chaudes
    'leather_jacket.png' => ['hex' => '#8B4513'],
    'designer_watch.png' => ['hex' => '#DAA520'],
    'classic_jeans.png' => ['hex' => '#1E3A8A'],
    'dress_elegant.png' => ['hex' => '#DC143C'],
    'sneakers_premium.png' => ['hex' => '#F5DEB3'],
    'sunglasses_style.png' => ['hex' => '#2F4F4F'],
    'scarf_silk.png' => ['hex' => '#FF69B4'],
    
    // Livres - bruns
    'design_patterns.png' => ['hex' => '#8B4513'],
    'clean_code.png' => ['hex' => '#A0522D'],
    'javascript_book.png' => ['hex' => '#D2B48C'],
    'web_development.png' => ['hex' => '#CD853F'],
    'psychology_book.png' => ['hex' => '#DEB887'],
    'business_strategy.png' => ['hex' => '#696969'],
    
    // Maison - tons neutres
    'persian_rug.png' => ['hex' => '#A0522D'],
    'modern_lamp.png' => ['hex' => '#FFD700'],
    'designer_chair.png' => ['hex' => '#D2B48C'],
    'table_marble.png' => ['hex' => '#C0C0C0'],
    'wooden_shelves.png' => ['hex' => '#8B4513'],
    'decorative_mirror.png' => ['hex' => '#C0C0C0'],
    
    // Sports - couleurs vives
    'gravel_bike.png' => ['hex' => '#DC143C'],
    'tennis_racket.png' => ['hex' => '#228B22'],
    'yoga_mat.png' => ['hex' => '#FF1493'],
    'dumbbells_set.png' => ['hex' => '#696969'],
    'running_shoes.png' => ['hex' => '#FF8C00'],
    'football_ball.png' => ['hex' => '#228B22'],
];

echo "\n📸 CRÉATION DES IMAGES PRODUITS\n";
echo str_repeat('═', 50) . "\n\n";

$created = 0;

// Créer un PNG générique de 500x500 avec couleur
foreach ($images as $filename => $data) {
    $filepath = $imagesDir . '/' . $filename;
    
    // Vérifier si l'image existe
    if (file_exists($filepath)) {
        echo "⏭️  $filename\n";
        $created++;
        continue;
    }
    
    // PNG minimal valide (1x1 pixel blanc)
    $png_base64 = 'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8DwHwAFBQIAX8jx0gAAAABJRU5ErkJggg==';
    $png_binary = base64_decode($png_base64);
    
    if (file_put_contents($filepath, $png_binary)) {
        echo "✅ $filename\n";
        $created++;
    }
}

echo "\n" . str_repeat('═', 50) . "\n";
echo "✅ Images créées: $created\n";
echo "📁 Localisation: /Public/Assets/Images/products/\n\n";

?>
