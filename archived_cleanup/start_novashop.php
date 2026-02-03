<?php
// Archived: moved to scripts/archived_start_novashop.php
die('This script was archived. See scripts/archived_start_novashop.php');
/**
 * Script de démarrage automatique NovaShop Pro
 * Initialise ou réinitialise complètement le projet
 * 
 * Usage: php start_novashop.php
 */

set_time_limit(300);
ini_set('display_errors', 1);

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║           🚀 NovaShop Pro - Démarrage Automatique         ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Configuration - Lire depuis les variables d'environnement ou utiliser les valeurs par défaut
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '0000';
$dbName = 'novashop';

// Étape 1: Créer les images locales
echo "📸 ÉTAPE 1: Création des images produits...\n";
echo str_repeat('─', 60) . "\n";

$imagesDir = __DIR__ . '/Public/Assets/Images/products';

if (!is_dir($imagesDir)) {
    @mkdir($imagesDir, 0755, true);
    echo "   ✅ Dossier images créé\n";
}

// Créer les 35 images PNG
$imageNames = [
    // Électronique
    'macbook_pro.png', 'wireless_headphones.png', 'iphone_camera.png',
    'smartwatch.png', 'mechanical_keyboard.png', 'gaming_mouse.png',
    'usb_hub.png', 'portable_charger.png', 'monitor_gaming.png', 'tablet.png',
    // Mode
    'leather_jacket.png', 'designer_watch.png', 'classic_jeans.png',
    'dress_elegant.png', 'sneakers_premium.png', 'sunglasses_style.png', 'scarf_silk.png',
    // Livres
    'design_patterns.png', 'clean_code.png', 'javascript_book.png',
    'web_development.png', 'psychology_book.png', 'business_strategy.png',
    // Maison
    'persian_rug.png', 'modern_lamp.png', 'designer_chair.png',
    'table_marble.png', 'wooden_shelves.png', 'decorative_mirror.png',
    // Sports
    'gravel_bike.png', 'tennis_racket.png', 'yoga_mat.png',
    'dumbbells_set.png', 'running_shoes.png', 'football_ball.png'
];

$pngData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');

$created = 0;
foreach ($imageNames as $imageName) {
    $filepath = $imagesDir . '/' . $imageName;
    if (!file_exists($filepath)) {
        file_put_contents($filepath, $pngData);
        $created++;
    }
}

echo "   ✅ " . count($imageNames) . " images prêtes\n\n";

// Étape 2: Connexion à la base de données
echo "🗄️  ÉTAPE 2: Initialisation de la base de données...\n";
echo str_repeat('─', 60) . "\n";

try {
    // Connexion pour vérifier le serveur
    $pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
    echo "   ✅ Connexion MySQL réussie\n";
    
    // Supprimer et recréer la base
    $pdo->exec("DROP DATABASE IF EXISTS $dbName");
    $pdo->exec("CREATE DATABASE $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    echo "   ✅ Base de données créée\n";
    
    // Utiliser la nouvelle base
    $pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    
} catch (PDOException $e) {
    echo "   ❌ Erreur de connexion: " . $e->getMessage() . "\n";
    echo "   💡 Assurez-vous que MySQL/MariaDB est lancé!\n";
    echo "   💡 Credentials: $dbUser / $dbPass sur $dbHost\n\n";
    exit(1);
}

// Étape 3: Créer les tables directement
echo "   📝 Création des tables...\n";

// Supprimer toutes les tables d'abord
$pdo->exec("SET FOREIGN_KEY_CHECKS=0");
$pdo->exec("DROP TABLE IF EXISTS order_items");
$pdo->exec("DROP TABLE IF EXISTS orders");
$pdo->exec("DROP TABLE IF EXISTS products");
$pdo->exec("DROP TABLE IF EXISTS categories");
$pdo->exec("DROP TABLE IF EXISTS users");
$pdo->exec("SET FOREIGN_KEY_CHECKS=1");

$createTables = <<<'SQL'
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    image_url VARCHAR(500),
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_category (category_id),
    FULLTEXT INDEX ft_search (name, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) DEFAULT 0,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT,
    INDEX idx_order (order_id),
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL;

$statements = array_filter(array_map('trim', preg_split('/;(\s+)?$/m', $createTables)));
foreach ($statements as $statement) {
    if (!empty($statement)) {
        try {
            $pdo->exec($statement);
        } catch (Exception $e) {
            // Ignorer certaines erreurs
        }
    }
}

echo "   ✅ Tables créées\n";

// Étape 4: Importer les données premium
echo "\n   📦 Insertion des données premium (35 produits)...\n";

// Données
$categories = [
    'Électronique' => 'Appareils électroniques, ordinateurs portables, accessoires technologiques',
    'Mode & Vêtements' => 'Vêtements tendance, accessoires de mode, collections exclusives',
    'Livres & Publications' => 'Littérature classique, livres techniques, publications éducatives',
    'Maison & Décor' => 'Mobilier, décoration intérieure, articles pour la maison',
    'Sports & Fitness' => 'Équipements sportifs, vêtements de sport, accessoires fitness'
];

// Insérer les utilisateurs
$users = [
    ['Alexandre Martin', 'admin@novashop.local', '$2y$10$ioclv8MtI9/7d/PCuak2AuD62.0FFY8Rq6pVG3Ccr79GD4rXV0Dmi', 'admin'],
    ['Marie Durand', 'marie.durand@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
    ['Jean Leclerc', 'jean.leclerc@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
    ['Sophie Bernard', 'sophie.bernard@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
    ['Thomas Petit', 'thomas.petit@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
    ['Isabelle Renard', 'isabelle.renard@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
];

$stmtUser = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
foreach ($users as $user) {
    $stmtUser->execute($user);
}

// Insérer les catégories
$stmtCat = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
$categoryIds = [];
foreach ($categories as $name => $desc) {
    $stmtCat->execute([$name, $desc]);
    $categoryIds[$name] = $pdo->lastInsertId();
}

// Produits premium (tous avec images locales)
$products = [
    // Électronique (1-8)
    ['Wireless Headphones Premium', 'Casque Bluetooth premium...', '/Assets/Images/products/product_001.png', 299.99, 'Électronique', 18],
    ['Smartphone Pro Max', 'Smartphone flagship...', '/Assets/Images/products/product_002.png', 899.99, 'Électronique', 12],
    ['Laptop Gaming Ultra', 'Ordinateur portable gaming...', '/Assets/Images/products/product_003.png', 1899.99, 'Électronique', 8],
    ['Smart Watch Elite', 'Montre intelligente ultra-durable...', '/Assets/Images/products/product_004.png', 449.99, 'Électronique', 15],
    ['Tablet 12.9 Inch', 'Tablette 12.9" premium...', '/Assets/Images/products/product_005.png', 699.99, 'Électronique', 10],
    ['Camera 4K Pro', 'Appareil photo 4K professionnel...', '/Assets/Images/products/product_006.png', 1299.99, 'Électronique', 5],
    ['Speaker Bluetooth', 'Haut-parleur Bluetooth premium...', '/Assets/Images/products/product_007.png', 199.99, 'Électronique', 25],
    ['USB-C Hub', 'Hub multiport USB-C 7-en-1...', '/Assets/Images/products/product_008.png', 89.99, 'Électronique', 30],
    
    // Mode & Vêtements (9-16)
    ['Leather Jacket Classic', 'Veste en cuir nappa premium...', '/Assets/Images/products/product_009.png', 399.99, 'Mode & Vêtements', 9],
    ['Designer Sunglasses', 'Lunettes de soleil designer...', '/Assets/Images/products/product_010.png', 179.99, 'Mode & Vêtements', 24],
    ['Premium Denim Jeans', 'Jeans premium coton stretch...', '/Assets/Images/products/product_011.png', 129.99, 'Mode & Vêtements', 35],
    ['Silk Dress Evening', 'Robe soie élégante...', '/Assets/Images/products/product_012.png', 249.99, 'Mode & Vêtements', 18],
    ['Athletic Sneakers', 'Baskets sport design...', '/Assets/Images/products/product_013.png', 159.99, 'Mode & Vêtements', 40],
    ['Wool Sweater Warm', 'Pull laine mérinos...', '/Assets/Images/products/product_014.png', 109.99, 'Mode & Vêtements', 22],
    ['Cotton T-Shirt', 'T-shirt coton premium...', '/Assets/Images/products/product_015.png', 39.99, 'Mode & Vêtements', 50],
    ['Silk Scarf', 'Écharpe 100% soie pure...', '/Assets/Images/products/product_016.png', 79.99, 'Mode & Vêtements', 28],
    
    // Livres (17-24)
    ['The Science Guide', 'Guide complet sciences...', '/Assets/Images/products/product_017.png', 34.99, 'Livres & Publications', 20],
    ['Python Programming', 'Maîtriser Python 3...', '/Assets/Images/products/product_018.png', 49.99, 'Livres & Publications', 25],
    ['Art History Complete', 'Histoire de l\'art complète...', '/Assets/Images/products/product_019.png', 59.99, 'Livres & Publications', 15],
    ['Cooking Recipes', 'Livre recettes gourmet...', '/Assets/Images/products/product_020.png', 29.99, 'Livres & Publications', 30],
    ['Business Strategy', 'Stratégie entrepreneurship...', '/Assets/Images/products/product_021.png', 44.99, 'Livres & Publications', 18],
    ['Fantasy Novel', 'Roman fantasy épique...', '/Assets/Images/products/product_022.png', 24.99, 'Livres & Publications', 35],
    ['Photography Tips', 'Guide photographie pro...', '/Assets/Images/products/product_023.png', 39.99, 'Livres & Publications', 22],
    ['Design Thinking', 'Méthode design thinking...', '/Assets/Images/products/product_024.png', 54.99, 'Livres & Publications', 17],
    
    // Maison & Décor (25-32)
    ['Modern Sofa Design', 'Canapé design moderne...', '/Assets/Images/products/product_025.png', 899.99, 'Maison & Décor', 4],
    ['Dining Table Set', 'Table salle à manger...', '/Assets/Images/products/product_026.png', 599.99, 'Maison & Décor', 3],
    ['LED Lamp Modern', 'Lampe LED design...', '/Assets/Images/products/product_027.png', 79.99, 'Maison & Décor', 15],
    ['Kitchen Utensils Set', 'Set ustensiles cuisine...', '/Assets/Images/products/product_028.png', 99.99, 'Maison & Décor', 20],
    ['Bed Frame Queen', 'Cadre lit Queen size...', '/Assets/Images/products/product_029.png', 449.99, 'Maison & Décor', 5],
    ['Wall Art Canvas', 'Tableau toile art...', '/Assets/Images/products/product_030.png', 149.99, 'Maison & Décor', 10],
    ['Outdoor Rug', 'Tapis extérieur premium...', '/Assets/Images/products/product_031.png', 199.99, 'Maison & Décor', 8],
    ['Plant Pot Ceramic', 'Pot plante céramique...', '/Assets/Images/products/product_032.png', 39.99, 'Maison & Décor', 25],
    
    // Sports & Fitness (33-35)
    ['Mountain Bike Pro', 'VTT cadre carbone...', '/Assets/Images/products/product_033.png', 1299.99, 'Sports & Fitness', 4],
    ['Yoga Mat Premium', 'Tapis yoga écologique...', '/Assets/Images/products/product_034.png', 79.99, 'Sports & Fitness', 32],
    ['Running Shoes Elite', 'Chaussures running pro...', '/Assets/Images/products/product_035.png', 159.99, 'Sports & Fitness', 28],
];

$stmtProduct = $pdo->prepare("INSERT INTO products (name, description, image_url, price, category_id, stock) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($products as $product) {
    $categoryId = $categoryIds[$product[4]];
    $stmtProduct->execute([$product[0], $product[1], $product[2], $product[3], $categoryId, $product[5]]);
}

echo "   ✅ 35 produits insérés\n";
echo "   ✅ 6 utilisateurs insérés\n";
echo "   ✅ 5 catégories insérées\n\n";

// Étape 5: Résumé
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║            ✅ INITIALISATION COMPLÉTÉE AVEC SUCCÈS         ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

$productCount = $pdo->query("SELECT COUNT(*) FROM products")->fetch()[0];
$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetch()[0];
$catCount = $pdo->query("SELECT COUNT(*) FROM categories")->fetch()[0];

echo "📊 État de la base de données:\n";
echo "   👥 Utilisateurs: $userCount\n";
echo "   📂 Catégories: $catCount\n";
echo "   🛍️  Produits: $productCount\n\n";

echo "🔐 Identifiants de test:\n";
echo "   Admin: admin@novashop.local / admin123\n";
echo "   User:  marie.durand@email.com / password123\n\n";

echo "🚀 Prêt à démarrer!\n";
echo "   Commande: php -S localhost:8000 router.php\n";
echo "   URL: http://localhost:8000\n\n";

?>
