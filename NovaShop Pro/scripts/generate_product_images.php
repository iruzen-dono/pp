#!/usr/bin/env php
<?php
/**
 * Script Ultra-Rapide : Génère des Images PNG Placeholder de Qualité
 * Plus rapide et plus fiable que Unsplash
 * Usage: php scripts/generate_product_images.php
 */

set_time_limit(0);

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   🎨 GÉNÉRATION IMAGES PRODUITS - PLACEHOLDERS PNG          ║\n";
echo "║   Méthode: ImageMagick local (ultra-rapide)                ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

$imagesDir = __DIR__ . '/../Public/Assets/Images/products';

// Créer répertoire
if (!is_dir($imagesDir)) {
    @mkdir($imagesDir, 0755, true);
    echo "✅ Répertoire créé: $imagesDir\n\n";
}

// Connexion BDD
try {
    require_once __DIR__ . '/../App/Config/Database.php';
    $db = \App\Config\Database::getConnection();
} catch (Exception $e) {
    die("❌ ERREUR BDD: " . $e->getMessage() . "\n");
}

$stmt = $db->query("SELECT id, name, SUBSTRING_INDEX(image_url, '/', -1) as filename FROM products ORDER BY id");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

if (empty($products)) {
    die("❌ Aucun produit\n");
}

echo "📊 Génération de " . count($products) . " images\n";
echo str_repeat('═', 60) . "\n\n";

$colors = [
    'Électronique' => '#1a73e8',  // Bleu
    'Mode' => '#ea4335',           // Rouge
    'Livres' => '#fbbc04',         // Jaune
    'Maison' => '#34a853',         // Vert
    'Sports' => '#ff6d00',         // Orange
];

// Mapping produit -> catégorie
$categoryMap = [
    1 => 'Électronique',
    2 => 'Mode',
    3 => 'Livres',
    4 => 'Maison',
    5 => 'Sports'
];

// Mapper chaque produit à sa catégorie
$categorized = [];
$stmt = $db->query("SELECT id, name, category_id, SUBSTRING_INDEX(image_url, '/', -1) as filename FROM products ORDER BY id");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($products as $product) {
    $categoryId = $product['category_id'];
    $category = $categoryMap[$categoryId] ?? 'Produit';
    $filename = $product['filename'];
    $filepath = $imagesDir . '/' . $filename;
    
    // Sauter si existe
    if (file_exists($filepath)) {
        echo "⏭️  {$filename} (existe)\n";
        continue;
    }
    
    $color = $colors[$category] ?? '#999999';
    $initials = implode('', array_map(fn($w) => $w[0], explode(' ', $product['name'])));
    $initials = substr($initials, 0, 3);
    
    // Générer avec ImageMagick
    $cmd = sprintf(
        'convert -size 500x500 xc:%s -fill white -pointsize 60 -gravity center -annotate +0+30 "%s" "%s" 2>&1',
        escapeshellarg($color),
        escapeshellarg($initials),
        escapeshellarg($filepath)
    );
    
    $output = shell_exec($cmd);
    
    if (file_exists($filepath) && filesize($filepath) > 500) {
        $sizeKb = round(filesize($filepath) / 1024, 1);
        echo "✅ {$filename} - {$initials} ({$sizeKb} KB)\n";
    } else {
        echo "⚠️  {$filename} - FALLBACK PNG (ImageMagick indisponible)\n";
        // Créer un simple PNG en PHP
        generateSimplePNG($filepath, $color, $initials);
    }
}

echo "\n" . str_repeat('═', 60) . "\n";
$files = array_filter(scandir($imagesDir), fn($f) => pathinfo($f, PATHINFO_EXTENSION) === 'png');
echo "✅ FAIT! " . count($files) . " images PNG\n";
echo "📂 " . $imagesDir . "\n\n";

// Fonction fallback : créer PNG simple en PHP
function generateSimplePNG($filepath, $bgColor, $text) {
    // Convertir hex à RGB
    $rgb = sscanf($bgColor, '#%02x%02x%02x');
    
    $width = 500;
    $height = 500;
    $image = imagecreatetruecolor($width, $height);
    
    $bgRgb = imagecolorallocate($image, $rgb[0], $rgb[1], $rgb[2]);
    $textColor = imagecolorallocate($image, 255, 255, 255);
    
    imagefilledrectangle($image, 0, 0, $width, $height, $bgRgb);
    
    // Ajouter du texte (utiliser font système)
    $fontSize = 80;
    $fontFile = __DIR__ . '/../Public/Assets/fonts/arial.ttf';
    
    if (file_exists($fontFile)) {
        imagettftext($image, $fontSize, 0, 150, 300, $textColor, $fontFile, $text);
    } else {
        // Fallback sans TTF
        imagestring($image, 5, 200, 220, $text, $textColor);
    }
    
    imagepng($image, $filepath, 9);
    imagedestroy($image);
}

?>
