<?php
/**
 * Script de génération d'images placeholder pour les produits
 * Génère des images PNG avec un dégradé et un icône
 */

require_once __DIR__ . '/../App/Config/Database.php';
use App\Config\Database;

$imagesDir = __DIR__ . '/../Public/Assets/Images/products';

// Couleurs pour différentes catégories de produits
$categoryColors = [
    'Électronique' => ['#667eea', '#764ba2'],
    'Livres' => ['#d4a574', '#c9915c'],
    'Vêtements' => ['#764ba2', '#667eea'],
    'Sports' => ['#2ecc71', '#27ae60'],
    'Maison' => ['#e74c3c', '#c0392b'],
    'Défaut' => ['#95a5a6', '#7f8c8d']
];

// Récupérer les produits sans bonnes images
$db = Database::getConnection();
$stmt = $db->query("
    SELECT p.id, p.name, c.name as category 
    FROM products p 
    LEFT JOIN categories c ON p.category_id = c.id
");

$products = $stmt->fetchAll();
$updated = 0;

echo "Génération d'images placeholder...\n";
echo "Nombre de produits: " . count($products) . "\n\n";

foreach ($products as $product) {
    $categoryName = $product['category'] ?? 'Défaut';
    $colors = $categoryColors[$categoryName] ?? $categoryColors['Défaut'];
    
    // Convertir les couleurs hex en RGB
    $color1 = hex2rgb($colors[0]);
    $color2 = hex2rgb($colors[1]);
    
    // Créer l'image
    $width = 400;
    $height = 400;
    $image = imagecreatetruecolor($width, $height);
    
    // Créer un dégradé
    for ($y = 0; $y < $height; $y++) {
        $ratio = $y / $height;
        $r = (int)($color1['r'] + ($color2['r'] - $color1['r']) * $ratio);
        $g = (int)($color1['g'] + ($color2['g'] - $color1['g']) * $ratio);
        $b = (int)($color1['b'] + ($color2['b'] - $color1['b']) * $ratio);
        
        $lineColor = imagecolorallocate($image, $r, $g, $b);
        imageline($image, 0, $y, $width, $y, $lineColor);
    }
    
    // Ajouter un carré blanc au centre avec un icône
    $squareSize = 120;
    $squareX = ($width - $squareSize) / 2;
    $squareY = ($height - $squareSize) / 2;
    
    $white = imagecolorallocate($image, 255, 255, 255);
    imagefilledrectangle($image, $squareX, $squareY, $squareX + $squareSize, $squareY + $squareSize, $white);
    
    // Écrire "📦" (boîte)
    $textColor = imagecolorallocate($image, 0, 0, 0);
    imagestring($image, 5, $squareX + 40, $squareY + 40, '📦', $textColor);
    
    // Sauvegarder l'image
    $filename = preg_replace('/[^a-z0-9_-]/', '_', strtolower($product['name'])) . '.png';
    $filepath = $imagesDir . '/' . $filename;
    
    if (imagepng($image, $filepath, 9)) {
        $updated++;
        echo "[✓] $filename\n";
    } else {
        echo "[✗] Erreur: $filename\n";
    }
    
    imagedestroy($image);
}

echo "\n✓ $updated images créées/mises à jour\n";

/**
 * Convertir une couleur hex en RGB
 */
function hex2rgb($hex) {
    $hex = str_replace('#', '', $hex);
    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));
    return ['r' => $r, 'g' => $g, 'b' => $b];
}
?>
