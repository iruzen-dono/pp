#!/usr/bin/env php
<?php
/**
 * Téléchargement de VRAIES Images depuis Unsplash
 * URLs Unsplash vérifiées et testées
 * Usage: php scripts/download_real_images.php
 */

set_time_limit(0);
ini_set('max_execution_time', 0);

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║   📸 TÉLÉCHARGEMENT VRAIES IMAGES - UNSPLASH               ║\n";
echo "║   Résolution: 500x500px | Format: PNG/JPG                ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

$imagesDir = './Public/Assets/Images/products';

if (!is_dir($imagesDir)) {
    @mkdir($imagesDir, 0755, true);
}

// URLs Unsplash vérifiées pour chaque produit
$imageUrls = [
    // ÉLECTRONIQUE (7)
    'macbook_pro.png' => [
        'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&h=500&fit=crop&q=80',
    ],
    'dell_xps.png' => [
        'https://images.unsplash.com/photo-1588872657840-790ff3bde172?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&h=500&fit=crop&q=80',
    ],
    'apple_watch.png' => [
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500&h=500&fit=crop&q=80',
    ],
    'sony_headphones.png' => [
        'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1487215078519-e21cc028cb29?w=500&h=500&fit=crop&q=80',
    ],
    'lg_ultrawide.png' => [
        'https://images.unsplash.com/photo-1522869635100-9f4c5e86aa37?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop&q=80',
    ],
    'tablet.png' => [
        'https://images.unsplash.com/photo-1552820728-8016266d5a27?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1580522539313-552107fabf5b?w=500&h=500&fit=crop&q=80',
    ],
    'power_bank.png' => [
        'https://images.unsplash.com/photo-1609042231671-bc09e37ddc74?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1591290621749-2127ba37f058?w=500&h=500&fit=crop&q=80',
    ],

    // MODE (7)
    'leather_jacket.png' => [
        'https://images.unsplash.com/photo-1551028719-00167b16ebc5?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop&q=80',
    ],
    'jeans.png' => [
        'https://images.unsplash.com/photo-1542272604-787c62e32fc9?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1542272604-787c62e32fc9?w=500&h=500&fit=crop&q=80',
    ],
    'shirt.png' => [
        'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1595777707802-21b745b1a01f?w=500&h=500&fit=crop&q=80',
    ],
    'sweater.png' => [
        'https://images.unsplash.com/photo-1516762714899-e1fb3e0b5f17?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1518895949257-7621c3c786d7?w=500&h=500&fit=crop&q=80',
    ],
    'sneakers.png' => [
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1460353581641-37baddab0fa2?w=500&h=500&fit=crop&q=80',
    ],
    'watch.png' => [
        'https://images.unsplash.com/photo-1523170335684-f1b5aef169d3?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1524592094714-0c6655c9674d?w=500&h=500&fit=crop&q=80',
    ],
    'sunglasses.png' => [
        'https://images.unsplash.com/photo-1572635196237-14b3f281503f?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1511499767150-a48a237aa25d?w=500&h=500&fit=crop&q=80',
    ],

    // LIVRES (7)
    'clean_code.png' => [
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=500&h=500&fit=crop&q=80',
    ],
    'pragmatic.png' => [
        'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop&q=80',
    ],
    'design_patterns.png' => [
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=500&h=500&fit=crop&q=80',
    ],
    'atomic_habits.png' => [
        'https://images.unsplash.com/photo-1543002588-d83fcc2e8ed2?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop&q=80',
    ],
    'zero_to_one.png' => [
        'https://images.unsplash.com/photo-1516979187457-637abb4f9353?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop&q=80',
    ],
    'python_ds.png' => [
        'https://images.unsplash.com/photo-1517694712202-14dd9538aa97?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1507842591343-583f20051fa3?w=500&h=500&fit=crop&q=80',
    ],
    'react_book.png' => [
        'https://images.unsplash.com/photo-1532012197267-da84d127e765?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&h=500&fit=crop&q=80',
    ],

    // MAISON (7)
    'desk_lamp.png' => [
        'https://images.unsplash.com/photo-1565636192335-14462d25de79?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1565636192335-14462d25de79?w=500&h=500&fit=crop&q=80',
    ],
    'artificial_plant.png' => [
        'https://images.unsplash.com/photo-1520763185298-1b434c919eba?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1577720643272-265e434e4f1e?w=500&h=500&fit=crop&q=80',
    ],
    'mirror.png' => [
        'https://images.unsplash.com/photo-1578500494198-246f612d03b3?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?w=500&h=500&fit=crop&q=80',
    ],
    'gaming_chair.png' => [
        'https://images.unsplash.com/photo-1527864550417-7fd91fc51a46?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1567538096051-b6643b2c9b3d?w=500&h=500&fit=crop&q=80',
    ],
    'shelves.png' => [
        'https://images.unsplash.com/photo-1467920591330-bea64389e7b0?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500&h=500&fit=crop&q=80',
    ],
    'rug.png' => [
        'https://images.unsplash.com/photo-1487033127519-95e86ddfcb4c?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1582159088659-1e71854e72e1?w=500&h=500&fit=crop&q=80',
    ],
    'bookshelf.png' => [
        'https://images.unsplash.com/photo-1467920591330-bea64389e7b0?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1524203596402-40b08a5ac603?w=500&h=500&fit=crop&q=80',
    ],

    // SPORTS (7)
    'gravel_bike.png' => [
        'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1491553895911-0055eca6402d?w=500&h=500&fit=crop&q=80',
    ],
    'dumbbells.png' => [
        'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1596133814575-3b721b19a87f?w=500&h=500&fit=crop&q=80',
    ],
    'yoga_mat.png' => [
        'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1506435773649-6f3db1b912d6?w=500&h=500&fit=crop&q=80',
    ],
    'garmin_watch.png' => [
        'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1546868871-7041f2a55e12?w=500&h=500&fit=crop&q=80',
    ],
    'trail_shoes.png' => [
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop&q=80',
    ],
    'backpack.png' => [
        'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop&q=80',
    ],
    'kettlebell.png' => [
        'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&h=500&fit=crop&q=80',
        'https://images.unsplash.com/photo-1596133814575-3b721b19a87f?w=500&h=500&fit=crop&q=80',
    ],
];

echo "📊 Total: " . count($imageUrls) . " images à télécharger\n";
echo str_repeat('═', 60) . "\n\n";

$downloaded = 0;
$failed = 0;
$failures = [];

foreach ($imageUrls as $filename => $urls) {
    $filepath = $imagesDir . '/' . $filename;
    
    // Vérifier si existe et >5KB
    if (file_exists($filepath) && filesize($filepath) > 5000) {
        $sizeKb = round(filesize($filepath) / 1024, 1);
        echo "⏭️  $filename ($sizeKb KB)\n";
        $downloaded++;
        continue;
    }
    
    echo "📥 $filename... ";
    $success = false;
    
    // Essayer chaque URL
    foreach ($urls as $url) {
        $context = stream_context_create([
            'http' => [
                'timeout' => 20,
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
                'follow_location' => true,
                'max_redirects' => 5
            ],
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false
            ]
        ]);
        
        $data = @file_get_contents($url, false, $context);
        
        if ($data && strlen($data) > 5000) {
            if (@file_put_contents($filepath, $data) !== false) {
                $sizeKb = round(filesize($filepath) / 1024, 1);
                echo "✅ ($sizeKb KB)\n";
                $downloaded++;
                $success = true;
                break;
            }
        }
        
        usleep(300000); // 300ms pause
    }
    
    if (!$success) {
        echo "❌ ÉCHEC\n";
        $failed++;
        $failures[] = $filename;
    }
}

echo "\n" . str_repeat('═', 60) . "\n";
echo "✅ Téléchargées: $downloaded/" . count($imageUrls) . "\n";
echo "❌ Échouées: $failed\n";

if (!empty($failures)) {
    echo "\n⚠️  Images non téléchargées:\n";
    foreach ($failures as $f) {
        echo "   • $f (fallback PNG)\n";
    }
    
    // Créer des fallback PNG pour les images échouées
    echo "\n⚙️  Génération des fallback PNG...\n";
    foreach ($failures as $f) {
        createPNG($imagesDir . '/' . $f);
        echo "  ✅ $f (fallback créé)\n";
    }
}

echo "\n📂 Total: " . count(glob("$imagesDir/*.png")) . " images PNG\n\n";

function createPNG($filepath) {
    $png = "\x89PNG\r\n\x1a\n";
    $ihdr_data = pack('N', 500) . pack('N', 500) . "\x08\x06\x00\x00\x00";
    $ihdr_crc = crc32("\x49\x48\x44\x52" . $ihdr_data);
    $png .= pack('N', 13) . "\x49\x48\x44\x52" . $ihdr_data . pack('N', $ihdr_crc);
    
    $scanlines = "";
    for ($y = 0; $y < 500; $y++) {
        $scanlines .= "\x00";
        for ($x = 0; $x < 500; $x++) {
            $gray = 220;
            $scanlines .= chr($gray) . chr($gray) . chr($gray) . "\xff";
        }
    }
    
    $compressed = gzcompress($scanlines);
    $idat_crc = crc32("\x49\x44\x41\x54" . $compressed);
    $png .= pack('N', strlen($compressed)) . "\x49\x44\x41\x54" . $compressed . pack('N', $idat_crc);
    
    $iend_crc = crc32("\x49\x45\x4e\x44");
    $png .= pack('N', 0) . "\x49\x45\x4e\x44" . pack('N', $iend_crc);
    
    file_put_contents($filepath, $png);
}

?>
