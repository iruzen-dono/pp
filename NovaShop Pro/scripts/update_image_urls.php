<?php
/**
 * Script de conversion des URLs Unsplash vers URLs locales
 */

$seedFile = __DIR__ . '/../seed_premium.sql';
$sql = file_get_contents($seedFile);

// Remplacer toutes les URLs Unsplash par des URLs locales
// Création d'un mapping simple: remplacer tous les URLs par des chemins locaux
$pattern = "'https://images.unsplash.com/photo-[0-9a-zA-Z\-]+\?w=500&h=500&fit=crop'";
$replacement = "'/Assets/Images/products/{IMAGE_NAME}'";

// Array de correspondances
$imageMap = [
    // Électronique
    'photo-1517336714731-489689fd1ca8' => 'macbook_pro.png',
    'photo-1588872657840-e5d3d701d819' => 'macbook_pro.png',
    'photo-1593642632823-8f785ba67e45' => 'wireless_headphones.png',
    'photo-1523275335684-37898b6baf30' => 'smartwatch.png',
    'photo-1505740420928-5e560c06d30e' => 'wireless_headphones.png',
    'photo-1484704849700-f032a568e944' => 'gaming_mouse.png',
    'photo-1484480974693-6ca0a78fb36b' => 'monitor_gaming.png',
    'photo-1612198188060-c7c2a3b66eae' => 'usb_hub.png',
    
    // Mode
    'photo-1551028719-00167b16ebc5' => 'leather_jacket.png',
    'photo-1582889385099-0a74c10fe607' => 'classic_jeans.png',
    'photo-1596755094514-f87e34085b2c' => 'dress_elegant.png',
    'photo-1521572163474-6864f9cf17ab' => 'sneakers_premium.png',
    'photo-1553062407-98eeb64c6a62' => 'sunglasses_style.png',
    'photo-1591195853828-11db59a44f6b' => 'scarf_silk.png',
    
    // Livres
    'photo-1512820790803-83ca734da794' => 'design_patterns.png',
    'photo-1507842217343-583f7270bfba' => 'clean_code.png',
    
    // Maison
    'photo-1565636192335-14c46fa1120d' => 'modern_lamp.png',
    'photo-1530836369250-ef72a3f5cda8' => 'decorative_mirror.png',
    'photo-1578749556568-bc2c40e68b61' => 'designer_chair.png',
    'photo-1611947391424-3a7fb3585b03' => 'designer_chair.png',
    'photo-1526749779700-7ee33bc25e94' => 'persian_rug.png',
    
    // Sports
    'photo-1532171875881-1e700285e7c0' => 'gravel_bike.png',
    'photo-1534438327276-14e5300c3a48' => 'dumbbells_set.png',
    'photo-1506126613408-eca07ce68773' => 'yoga_mat.png',
    'photo-1542291026-7eec264c27ff' => 'running_shoes.png',
];

// Effectuer les remplacements
foreach ($imageMap as $photoId => $imageName) {
    $oldUrl = "'https://images.unsplash.com/$photoId?w=500&h=500&fit=crop'";
    $newUrl = "'/Assets/Images/products/$imageName'";
    $sql = str_replace($oldUrl, $newUrl, $sql);
    echo "✅ $photoId → $imageName\n";
}

// Sauvegarder le fichier modifié
if (file_put_contents($seedFile, $sql)) {
    echo "\n✅ seed_premium.sql mis à jour avec succès!\n";
    echo "📁 Toutes les images pointent maintenant vers /Assets/Images/products/\n";
} else {
    echo "\n❌ Erreur lors de la sauvegarde du fichier\n";
}

?>
