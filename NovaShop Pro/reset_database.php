<?php
// Simpler approach - load config and execute SQL properly
$config = require 'App/Config/env.php';

try {
    // Connection to MySQL
    $pdo = new PDO(
        "mysql:host={$config['db_host']}",
        $config['db_user'],
        $config['db_pass'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );

    echo "✓ Connected to MySQL\n";

    $dbName = $config['db_name'];
    
    // Drop and create database
    $pdo->exec("DROP DATABASE IF EXISTS `$dbName`");
    $pdo->exec("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbName`");

    echo "✓ Database created\n";

    // Now execute setup.sql line by line, properly
    $sql = file_get_contents('setup.sql');
    
    // Remove comments
    $sql = preg_replace('/--.*?$/m', '', $sql);
    $sql = preg_replace('/\/\*.*?\*\//s', '', $sql);
    
    // Split by semicolon, but be careful
    $statements = array_filter(
        array_map('trim', explode(';', $sql)),
        fn($s) => !empty($s)
    );

    foreach ($statements as $idx => $statement) {
        if (trim($statement)) {
            try {
                $pdo->exec($statement);
                echo ".";
            } catch (PDOException $e) {
                echo "\n❌ Statement " . ($idx + 1) . " failed:\n";
                echo "   " . substr($statement, 0, 80) . "...\n";
                echo "   Error: " . $e->getMessage() . "\n";
            }
        }
    }

    // Verify
    $pdo = new PDO(
        "mysql:host={$config['db_host']};dbname={$dbName}",
        $config['db_user'],
        $config['db_pass'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true]
    );
    
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "\nTables created: " . count($tables) . "\n";
    foreach ($tables as $t) {
        echo "  - $t\n";
    }

    $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
    echo "\nTest users: $userCount\n";

    // Insert 20 test products
    $products = [
        ['iPhone 15 Pro', 'Smartphone haut de gamme avec écran AMOLED 6.1", processeur A17 Pro, caméra 48MP', 999.99, 1, 15, 'Noir, Bleu, Or, Blanc'],
        ['Samsung Galaxy S24', 'Téléphone Android avec écran AMOLED 6.2", processeur Snapdragon 8 Gen 3, batterie 4000mAh', 899.99, 1, 22, 'Noir, Argent, Vert'],
        ['iPad Air 11"', 'Tablette haute performance avec écran Liquid Retina 11", chip M2, 128GB', 599.99, 1, 10, '128GB, 256GB, 512GB'],
        ['MacBook Pro 16"', 'Ordinateur portable professionnel avec M3 Max, 36GB RAM, SSD 1TB, écran Retina', 2499.99, 1, 5, '512GB, 1TB, 2TB'],
        ['AirPods Pro', 'Écouteurs sans fil avec réduction active du bruit, qualité audio Hi-Fi', 249.99, 1, 45, 'Standard, MagSafe'],
        ['Sony WH-1000XM5', 'Casque audio avec réduction du bruit leader du marché, autonomie 30h', 379.99, 1, 20, 'Noir, Argent, Bleu'],
        ['T-Shirt Premium 100% Coton', 'T-shirt confortable en coton biologique de qualité supérieure, finition impeccable', 29.99, 2, 80, 'XS, S, M, L, XL, XXL'],
        ['Jeans Slim Fit', 'Jean classique bleu indigo avec coupe slim, longueur adaptable', 49.99, 2, 60, '28, 30, 32, 34, 36, 38'],
        ['Veste d\'Hiver Premium', 'Veste chaude avec doublure polaire, imperméable, poche intérieure', 129.99, 2, 30, 'XS, S, M, L, XL'],
        ['Chemise Casual Noir', 'Chemise élégante en coton, parfaite pour le bureau ou soirée', 59.99, 2, 40, 'S, M, L, XL, XXL'],
        ['Clean Code - Robert C. Martin', 'Guide complet pour écrire du code de qualité, pratiques meilleures et refactoring', 39.99, 3, 35, 'Broché, Relié'],
        ['The Pragmatic Programmer', 'Conseils pratiques et essentiels pour les développeurs modernes', 44.99, 3, 28, 'Broché, Relié, E-book'],
        ['Design Patterns - Gang of Four', 'Les 23 motifs de conception élémentaires pour l\'ingénierie logicielle', 54.99, 3, 20, 'Broché, Relié'],
        ['Sapiens - Yuval Noah Harari', 'Une brève histoire de l\'humanité, passionnant et révélateur', 24.99, 3, 50, 'Broché, Poche'],
        ['Lampe LED Moderne', 'Lampe de bureau LED avec contrôle tactile, 3 niveaux de luminosité', 34.99, 4, 40, 'Blanc, Noir, Or'],
        ['Tapis Shag Gris', 'Tapis moelleux 200x300cm, lavable, isolation thermique', 89.99, 4, 15, '150x200, 200x300, 250x350'],
        ['Coussins Décor Set de 4', 'Ensemble de 4 coussins décoratifs avec fermeture éclair, confort optimal', 44.99, 4, 55, 'Gris, Bleu, Beige'],
        ['Miroir Mural Rond 60cm', 'Miroir décoratif avec cadre métallique doré, reflet cristallin', 69.99, 4, 25, '40cm, 60cm, 80cm'],
        ['Plantes Artificielles (Lot de 3)', 'Ensemble de plantes décoratives réalistes, sans entretien', 24.99, 4, 60, 'Avec pot, Sans pot'],
        ['Airfryer Philips Premium', 'Cuiseur à air frais avec contrôle tactile, contenance 4.2L, affichage LED', 149.99, 4, 18, '4.2L, 6.2L'],
    ];

    $stmt = $pdo->prepare("INSERT INTO products (name, description, price, category_id, stock, variants) VALUES (?, ?, ?, ?, ?, ?)");
    
    foreach ($products as $product) {
        try {
            $stmt->execute($product);
        } catch (PDOException $e) {
            echo "❌ Failed to insert product: " . $product[0] . "\n";
        }
    }

    $productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
    echo "📦 Test products: $productCount\n";

    echo "\n✅ SUCCESS!\n";

} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
?>
