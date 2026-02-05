<?php
/**
 * Script pour insérer 20 produits de test
 * Exécution: php seed_products.php
 */

// Autoloader
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

$db = \App\Core\Database::getInstance();

$products = [
    // Électronique
    [
        'name' => 'iPhone 15 Pro',
        'description' => 'Smartphone haut de gamme avec écran AMOLED 6.1", processeur A17 Pro, caméra 48MP',
        'price' => 999.99,
        'category_id' => 1,
        'stock' => 15,
        'variants' => 'Noir, Bleu, Or, Blanc'
    ],
    [
        'name' => 'Samsung Galaxy S24',
        'description' => 'Téléphone Android avec écran AMOLED 6.2", processeur Snapdragon 8 Gen 3, batterie 4000mAh',
        'price' => 899.99,
        'category_id' => 1,
        'stock' => 22,
        'variants' => 'Noir, Argent, Vert'
    ],
    [
        'name' => 'iPad Air 11"',
        'description' => 'Tablette haute performance avec écran Liquid Retina 11", chip M2, 128GB',
        'price' => 599.99,
        'category_id' => 1,
        'stock' => 10,
        'variants' => '128GB, 256GB, 512GB'
    ],
    [
        'name' => 'MacBook Pro 16"',
        'description' => 'Ordinateur portable professionnel avec M3 Max, 36GB RAM, SSD 1TB, écran Retina',
        'price' => 2499.99,
        'category_id' => 1,
        'stock' => 5,
        'variants' => '512GB, 1TB, 2TB'
    ],
    [
        'name' => 'AirPods Pro',
        'description' => 'Écouteurs sans fil avec réduction active du bruit, qualité audio Hi-Fi',
        'price' => 249.99,
        'category_id' => 1,
        'stock' => 45,
        'variants' => 'Standard, MagSafe'
    ],
    [
        'name' => 'Sony WH-1000XM5',
        'description' => 'Casque audio avec réduction du bruit leader du marché, autonomie 30h',
        'price' => 379.99,
        'category_id' => 1,
        'stock' => 20,
        'variants' => 'Noir, Argent, Bleu'
    ],
    
    // Vêtements
    [
        'name' => 'T-Shirt Premium 100% Coton',
        'description' => 'T-shirt confortable en coton biologique de qualité supérieure, finition impeccable',
        'price' => 29.99,
        'category_id' => 2,
        'stock' => 80,
        'variants' => 'XS, S, M, L, XL, XXL'
    ],
    [
        'name' => 'Jeans Slim Fit',
        'description' => 'Jean classique bleu indigo avec coupe slim, longueur adaptable',
        'price' => 49.99,
        'category_id' => 2,
        'stock' => 60,
        'variants' => '28, 30, 32, 34, 36, 38'
    ],
    [
        'name' => 'Veste d\'Hiver Premium',
        'description' => 'Veste chaude avec doublure polaire, imperméable, poche intérieure',
        'price' => 129.99,
        'category_id' => 2,
        'stock' => 30,
        'variants' => 'XS, S, M, L, XL'
    ],
    [
        'name' => 'Chemise Casual Noir',
        'description' => 'Chemise élégante en coton, parfaite pour le bureau ou soirée',
        'price' => 59.99,
        'category_id' => 2,
        'stock' => 40,
        'variants' => 'S, M, L, XL, XXL'
    ],
    
    // Livres
    [
        'name' => 'Clean Code - Robert C. Martin',
        'description' => 'Guide complet pour écrire du code de qualité, pratiques meilleures et refactoring',
        'price' => 39.99,
        'category_id' => 3,
        'stock' => 35,
        'variants' => 'Broché, Relié'
    ],
    [
        'name' => 'The Pragmatic Programmer',
        'description' => 'Conseils pratiques et essentiels pour les développeurs modernes',
        'price' => 44.99,
        'category_id' => 3,
        'stock' => 28,
        'variants' => 'Broché, Relié, E-book'
    ],
    [
        'name' => 'Design Patterns - Gang of Four',
        'description' => 'Les 23 motifs de conception élémentaires pour l\'ingénierie logicielle',
        'price' => 54.99,
        'category_id' => 3,
        'stock' => 20,
        'variants' => 'Broché, Relié'
    ],
    [
        'name' => 'Sapiens - Yuval Noah Harari',
        'description' => 'Une brève histoire de l\'humanité, passionnant et révélateur',
        'price' => 24.99,
        'category_id' => 3,
        'stock' => 50,
        'variants' => 'Broché, Poche'
    ],
    
    // Maison
    [
        'name' => 'Lampe LED Moderne',
        'description' => 'Lampe de bureau LED avec contrôle tactile, 3 niveaux de luminosité',
        'price' => 34.99,
        'category_id' => 4,
        'stock' => 40,
        'variants' => 'Blanc, Noir, Or'
    ],
    [
        'name' => 'Tapis Shag Gris',
        'description' => 'Tapis moelleux 200x300cm, lavable, isolation thermique',
        'price' => 89.99,
        'category_id' => 4,
        'stock' => 15,
        'variants' => '150x200, 200x300, 250x350'
    ],
    [
        'name' => 'Coussins Décor Set de 4',
        'description' => 'Ensemble de 4 coussins décoratifs avec fermeture éclair, confort optimal',
        'price' => 44.99,
        'category_id' => 4,
        'stock' => 55,
        'variants' => 'Gris, Bleu, Beige'
    ],
    [
        'name' => 'Miroir Mural Rond 60cm',
        'description' => 'Miroir décoratif avec cadre métallique doré, reflet cristallin',
        'price' => 69.99,
        'category_id' => 4,
        'stock' => 25,
        'variants' => '40cm, 60cm, 80cm'
    ],
    [
        'name' => 'Plantes Artificielles (Lot de 3)',
        'description' => 'Ensemble de plantes décoratives réalistes, sans entretien',
        'price' => 24.99,
        'category_id' => 4,
        'stock' => 60,
        'variants' => 'Avec pot, Sans pot'
    ],
];

try {
    // Commencer la transaction
    $db->beginTransaction();
    
    $inserted = 0;
    
    foreach ($products as $product) {
        $stmt = $db->prepare(
            "INSERT INTO products (name, description, price, category_id, stock, variants) 
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        
        $stmt->execute([
            $product['name'],
            $product['description'],
            $product['price'],
            $product['category_id'],
            $product['stock'],
            $product['variants']
        ]);
        
        $inserted++;
    }
    
    // Valider la transaction
    $db->commit();
    
    echo "✅ SUCCESS!\n";
    echo "📦 {$inserted} produits insérés avec succès\n";
    echo "\n📊 Résumé:\n";
    echo "  • Électronique: 6 produits\n";
    echo "  • Vêtements: 4 produits\n";
    echo "  • Livres: 4 produits\n";
    echo "  • Maison: 5 produits\n";
    echo "\n💡 Accédez à http://novashop.local pour tester!\n";
    
} catch (\Exception $e) {
    $db->rollBack();
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
    exit(1);
}
