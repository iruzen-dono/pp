#!/usr/bin/env php
<?php
/**
 * Génère des images PNG binaires simples mais valides
 * Aucune dépendance GD, aucune API externe
 * 100% fiable et rapide
 */

$imagesDir = './Public/Assets/Images/products';

$db = new PDO('mysql:host=localhost;dbname=novashop', 'root', '0000');
$stmt = $db->query("
    SELECT SUBSTRING_INDEX(image_url, '/', -1) as filename 
    FROM products ORDER BY filename
");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo "\n╔════════════════════════════════════════════════════════════╗\n";
echo "║ 🎨 GÉNÉRATION PNG BINAIRES - Fallback Universel            ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

$created = 0;
foreach ($products as $p) {
    $file = $imagesDir . '/' . $p['filename'];
    
    if (file_exists($file) && filesize($file) > 500) {
        continue;
    }
    
    // Créer un PNG valide minimum (1x1 pixel RGBA)
    $png = createMinimalPNG(500, 500);
    
    if (file_put_contents($file, $png)) {
        $kb = round(filesize($file) / 1024, 2);
        echo "✅ " . $p['filename'] . " ({$kb} KB)\n";
        $created++;
    }
}

echo "\n📊 Créées: $created | Total: " . count(glob("$imagesDir/*.png")) . " PNG\n\n";

function createMinimalPNG($width, $height) {
    // PNG signature
    $png = "\x89PNG\r\n\x1a\n";
    
    // IHDR chunk (width, height, bit depth, color type, etc.)
    $ihdr_data = pack('N', $width) . pack('N', $height) . "\x08\x06\x00\x00\x00";
    $ihdr_crc = crc32("\x49\x48\x44\x52" . $ihdr_data);
    $png .= pack('N', 13) . "\x49\x48\x44\x52" . $ihdr_data . pack('N', $ihdr_crc);
    
    // IDAT chunk (image data) - simple gradient gray
    $scanlines = "";
    for ($y = 0; $y < $height; $y++) {
        $scanlines .= "\x00"; // filter type
        for ($x = 0; $x < $width; $x++) {
            $gray = 200;
            $scanlines .= chr($gray) . chr($gray) . chr($gray) . "\xff";
        }
    }
    
    $compressed = gzcompress($scanlines);
    $idat_crc = crc32("\x49\x44\x41\x54" . $compressed);
    $png .= pack('N', strlen($compressed)) . "\x49\x44\x41\x54" . $compressed . pack('N', $idat_crc);
    
    // IEND chunk
    $iend_crc = crc32("\x49\x45\x4e\x44");
    $png .= pack('N', 0) . "\x49\x45\x4e\x44" . pack('N', $iend_crc);
    
    return $png;
}

?>
