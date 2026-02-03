<?php
/**
 * Script de mise à jour des images dans la base de données
 * Remplace les URLs Unsplash par les chemins locaux
 */

echo "\n🖼️  MISE À JOUR DES IMAGES EN BASE DE DONNÉES\n";
echo str_repeat('═', 50) . "\n\n";

try {
    // Connexion à la base
    $pdo = new PDO(
        'mysql:host=localhost;dbname=novashop;charset=utf8mb4',
        'root',
        '0000'
    );
    
    // Mapping des images
    $imageMap = [
        'photo-1517336714731-489689fd1ca8' => '/Assets/Images/products/macbook_pro.png',
        'photo-1588872657840-e5d3d701d819' => '/Assets/Images/products/macbook_pro.png',
        'photo-1593642632823-8f785ba67e45' => '/Assets/Images/products/wireless_headphones.png',
        'photo-1523275335684-37898b6baf30' => '/Assets/Images/products/smartwatch.png',
        'photo-1505740420928-5e560c06d30e' => '/Assets/Images/products/wireless_headphones.png',
        'photo-1484704849700-f032a568e944' => '/Assets/Images/products/gaming_mouse.png',
        'photo-1484480974693-6ca0a78fb36b' => '/Assets/Images/products/monitor_gaming.png',
        'photo-1612198188060-c7c2a3b66eae' => '/Assets/Images/products/usb_hub.png',
        'photo-1551028719-00167b16ebc5' => '/Assets/Images/products/leather_jacket.png',
        'photo-1582889385099-0a74c10fe607' => '/Assets/Images/products/classic_jeans.png',
        'photo-1596755094514-f87e34085b2c' => '/Assets/Images/products/dress_elegant.png',
        'photo-1521572163474-6864f9cf17ab' => '/Assets/Images/products/sneakers_premium.png',
        'photo-1553062407-98eeb64c6a62' => '/Assets/Images/products/sunglasses_style.png',
        'photo-1591195853828-11db59a44f6b' => '/Assets/Images/products/scarf_silk.png',
        'photo-1512820790803-83ca734da794' => '/Assets/Images/products/design_patterns.png',
        'photo-1507842217343-583f7270bfba' => '/Assets/Images/products/clean_code.png',
        'photo-1565636192335-14c46fa1120d' => '/Assets/Images/products/modern_lamp.png',
        'photo-1530836369250-ef72a3f5cda8' => '/Assets/Images/products/decorative_mirror.png',
        'photo-1578749556568-bc2c40e68b61' => '/Assets/Images/products/designer_chair.png',
        'photo-1611947391424-3a7fb3585b03' => '/Assets/Images/products/designer_chair.png',
        'photo-1526749779700-7ee33bc25e94' => '/Assets/Images/products/persian_rug.png',
        'photo-1532171875881-1e700285e7c0' => '/Assets/Images/products/gravel_bike.png',
        'photo-1534438327276-14e5300c3a48' => '/Assets/Images/products/dumbbells_set.png',
        'photo-1506126613408-eca07ce68773' => '/Assets/Images/products/yoga_mat.png',
        'photo-1542291026-7eec264c27ff' => '/Assets/Images/products/running_shoes.png',
    ];
    
    // Effectuer les mises à jour
    $updated = 0;
    foreach ($imageMap as $photoId => $localPath) {
        $oldUrl = "https://images.unsplash.com/$photoId?w=500&h=500&fit=crop";
        $stmt = $pdo->prepare("UPDATE products SET image_url = ? WHERE image_url LIKE ?");
        
        if ($stmt->execute([$localPath, "%$photoId%"])) {
            $affected = $stmt->rowCount();
            if ($affected > 0) {
                echo "✅ $photoId → $localPath ($affected produit(s))\n";
                $updated += $affected;
            }
        }
    }
    
    echo "\n" . str_repeat('═', 50) . "\n";
    echo "📊 RÉSULTATS:\n";
    echo "✅ Total produits mis à jour: $updated\n";
    
    // Afficher les produits avec leurs nouvelles URLs
    $products = $pdo->query("SELECT id, name, image_url FROM products ORDER BY category_id, id LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
    
    echo "\n📸 Aperçu des premiers produits:\n";
    foreach ($products as $product) {
        echo "   • " . $product['name'] . "\n     → " . $product['image_url'] . "\n";
    }
    
    echo "\n✅ Mise à jour terminée!\n\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n\n";
}

?>
