<?php
/**
 * Script de remplissage complet de la BD avec données aléatoires
 * Crée: produits, images, commandes, etc.
 * Usage: php scripts/seed_complete_data.php
 */

// Configuration
chdir(__DIR__ . '/..');
require_once 'App/Config/Database.php';

$db = \App\Config\Database::getConnection();

// Créer la table email_verification_tokens si elle n'existe pas
try {
    $db->exec("
        CREATE TABLE IF NOT EXISTS email_verification_tokens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            token VARCHAR(255) NOT NULL UNIQUE,
            expires_at TIMESTAMP NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            INDEX idx_user (user_id),
            INDEX idx_token (token),
            INDEX idx_expires (expires_at)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ");
    echo "✅ Table email_verification_tokens créée/vérifiée\n";
} catch (Exception $e) {
    echo "⚠️ Table email_verification_tokens: " . $e->getMessage() . "\n";
}

// Données de produits aléatoires
$products = [
    // Électronique
    ['name' => 'iPhone 15 Pro Max', 'description' => 'Smartphone dernier cri avec écran OLED', 'price' => 1299.99, 'stock' => 25, 'category_id' => 1, 'variants' => 'Noir, Blanc, Bleu, Doré', 'image' => 'https://images.unsplash.com/photo-1592286927505-1def25115558?w=500'],
    ['name' => 'MacBook Pro 16"', 'description' => 'Ordinateur portable haute performance', 'price' => 2499.99, 'stock' => 15, 'category_id' => 1, 'variants' => '512GB, 1TB, 2TB', 'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500'],
    ['name' => 'iPad Air', 'description' => 'Tablette polyvalente 11 pouces', 'price' => 799.99, 'stock' => 30, 'category_id' => 1, 'variants' => '64GB, 256GB', 'image' => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=500'],
    ['name' => 'Sony WH-1000XM5', 'description' => 'Casque bluetooth sans fil premium', 'price' => 449.99, 'stock' => 50, 'category_id' => 1, 'variants' => 'Noir, Argent, Bleu', 'image' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500'],
    ['name' => 'Samsung 55" TV QLED', 'description' => 'Téléviseur 4K avec technologie QLED', 'price' => 1199.99, 'stock' => 10, 'category_id' => 1, 'variants' => '4K, 8K', 'image' => 'https://images.unsplash.com/photo-1598327105666-5b89351aff97?w=500'],
    
    // Vêtements
    ['name' => 'Jean Slim Premium', 'description' => 'Jeans confortable coupe slim', 'price' => 79.99, 'stock' => 100, 'category_id' => 2, 'variants' => 'XS, S, M, L, XL, XXL', 'image' => 'https://images.unsplash.com/photo-1542272604-787c62d465d1?w=500'],
    ['name' => 'T-Shirt Coton Bio', 'description' => 'T-shirt écologique 100% coton biologique', 'price' => 34.99, 'stock' => 150, 'category_id' => 2, 'variants' => 'Blanc, Noir, Gris, Bleu', 'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500'],
    ['name' => 'Veste Cuir Noir', 'description' => 'Veste en cuir véritable style motard', 'price' => 249.99, 'stock' => 25, 'category_id' => 2, 'variants' => 'S, M, L, XL', 'image' => 'https://images.unsplash.com/photo-1551028719-00167b16ebc5?w=500'],
    ['name' => 'Robe Élégante', 'description' => 'Robe soirée noire élégante', 'price' => 159.99, 'stock' => 40, 'category_id' => 2, 'variants' => 'XS, S, M, L', 'image' => 'https://images.unsplash.com/photo-1595777707802-41d335b76b23?w=500'],
    ['name' => 'Sneakers Blanches', 'description' => 'Chaussures de sport confortables', 'price' => 129.99, 'stock' => 80, 'category_id' => 2, 'variants' => '36, 37, 38, 39, 40, 41, 42, 43, 44, 45', 'image' => 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=500'],
    
    // Livres
    ['name' => 'Clean Code', 'description' => 'Livre de Robert C. Martin sur le code propre', 'price' => 45.99, 'stock' => 60, 'category_id' => 3, 'variants' => 'Broché, Relié, Kindle', 'image' => 'https://images.unsplash.com/photo-1507842217343-583f20270319?w=500'],
    ['name' => 'Le Seigneur des Anneaux', 'description' => 'Trilogie classique de Tolkien', 'price' => 34.99, 'stock' => 120, 'category_id' => 3, 'variants' => 'Intégrale', 'image' => 'https://images.unsplash.com/photo-1507842217343-583f20270319?w=500'],
    ['name' => 'Design Patterns', 'description' => 'Gang of Four design patterns', 'price' => 55.99, 'stock' => 45, 'category_id' => 3, 'variants' => 'Broché, Numérique', 'image' => 'https://images.unsplash.com/photo-1518836357266-8217e50f7882?w=500'],
    
    // Maison
    ['name' => 'Lampe Murale LED', 'description' => 'Lampe design moderne avec variateur', 'price' => 89.99, 'stock' => 70, 'category_id' => 4, 'variants' => 'Blanc Chaud, Blanc Froid', 'image' => 'https://images.unsplash.com/photo-1565636192335-14c0b3e90e68?w=500'],
    ['name' => 'Miroir Mural Doré', 'description' => 'Miroir cadre or style scandinave', 'price' => 129.99, 'stock' => 35, 'category_id' => 4, 'variants' => 'Petit, Moyen, Grand', 'image' => 'https://images.unsplash.com/photo-1533090161767-e6ffb854cdb9?w=500'],
    ['name' => 'Plaid Gris Cozy', 'description' => 'Couverture cosy pour le canapé', 'price' => 49.99, 'stock' => 90, 'category_id' => 4, 'variants' => 'Gris, Beige, Anthracite', 'image' => 'https://images.unsplash.com/photo-1552820728-8ac41f1ce891?w=500'],
    ['name' => 'Coussin Décoratif', 'description' => 'Lot de 4 coussins décoration', 'price' => 69.99, 'stock' => 55, 'category_id' => 4, 'variants' => 'Motif 1, Motif 2, Motif 3', 'image' => 'https://images.unsplash.com/photo-1595521624604-e96e84f89dfe?w=500'],
    ['name' => 'Table Basse Design', 'description' => 'Table basse en bois massif', 'price' => 249.99, 'stock' => 20, 'category_id' => 4, 'variants' => 'Chêne, Noyer, Beige', 'image' => 'https://images.unsplash.com/photo-1555041469-a586c61ea9bc?w=500'],
];

// Créer dossier images s'il n'existe pas
$imgDir = __DIR__ . '/../Public/Assets/Images/products/';
if (!is_dir($imgDir)) {
    mkdir($imgDir, 0755, true);
    echo "📁 Dossier d'images créé: $imgDir\n";
}

// Insérer les produits
echo "\n📦 Insertion des produits...\n";
$stmt = $db->prepare(
    "INSERT INTO products (name, description, price, stock, category_id, variants, image_url) 
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);

$productIds = [];
foreach ($products as $idx => $product) {
    try {
        // Télécharger et sauvegarder l'image
        $imageUrl = $product['image'];
        $fileName = 'product_' . ($idx + 1) . '_' . time() . '.jpg';
        $filePath = $imgDir . $fileName;
        
        // Essayer de télécharger l'image
        $imageData = @file_get_contents($imageUrl);
        if ($imageData !== false) {
            file_put_contents($filePath, $imageData);
            $savedImage = '/Assets/Images/products/' . $fileName;
            echo "   ✅ Image téléchargée: {$product['name']} → /$fileName\n";
        } else {
            $savedImage = $imageUrl; // Fallback à l'URL
            echo "   ⚠️  Image externe: {$product['name']}\n";
        }
        
        // Insérer le produit
        $stmt->execute([
            $product['name'],
            $product['description'],
            $product['price'],
            $product['stock'],
            $product['category_id'],
            $product['variants'],
            $savedImage
        ]);
        
        $productIds[] = $db->lastInsertId();
        echo "   ✅ {$product['name']} (ID: {$db->lastInsertId()}) - Stock: {$product['stock']} - Prix: {$product['price']}€\n";
        
    } catch (Exception $e) {
        echo "   ❌ Erreur: {$product['name']} - " . $e->getMessage() . "\n";
    }
}

echo "\n✅ " . count($productIds) . " produits créés!\n";

// Créer des commandes de test
echo "\n📋 Création de commandes de test...\n";

$userIds = [1, 2]; // Admin et Client Test
$statuses = ['pending', 'confirmed', 'shipped', 'delivered'];

$orderCount = 0;
foreach ($userIds as $userId) {
    // Créer 2-3 commandes par utilisateur
    for ($i = 0; $i < rand(2, 3); $i++) {
        try {
            // Créer la commande
            $status = $statuses[array_rand($statuses)];
            $total = rand(5, 50) * 10; // Total aléatoire
            
            $orderStmt = $db->prepare(
                "INSERT INTO orders (user_id, total, status) VALUES (?, ?, ?)"
            );
            $orderStmt->execute([$userId, $total, $status]);
            $orderId = $db->lastInsertId();
            
            // Ajouter 1-3 articles à la commande
            $itemsCount = rand(1, 3);
            for ($j = 0; $j < $itemsCount; $j++) {
                $productId = $productIds[array_rand($productIds)];
                $quantity = rand(1, 5);
                $itemPrice = rand(20, 200);
                
                $itemStmt = $db->prepare(
                    "INSERT INTO order_items (order_id, product_id, quantity, price) 
                     VALUES (?, ?, ?, ?)"
                );
                $itemStmt->execute([$orderId, $productId, $quantity, $itemPrice]);
            }
            
            $orderCount++;
            echo "   ✅ Commande #$orderId (User: $userId, Status: $status, Total: {$total}€)\n";
            
        } catch (Exception $e) {
            echo "   ❌ Erreur création commande: " . $e->getMessage() . "\n";
        }
    }
}

echo "✅ $orderCount commandes créées!\n";

// Ajouter des tokens de réinitialisation de mot de passe
echo "\n🔑 Création de tokens de réinitialisation...\n";

$tokenCount = 0;
foreach ($userIds as $userId) {
    try {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', time() + 3600); // 1h d'expiration
        
        $tokenStmt = $db->prepare(
            "INSERT INTO password_reset_tokens (user_id, token, expires_at) 
             VALUES (?, ?, ?)"
        );
        $tokenStmt->execute([$userId, $token, $expiresAt]);
        $tokenCount++;
        
        echo "   ✅ Token token pour user $userId\n";
    } catch (Exception $e) {
        echo "   ❌ Erreur: " . $e->getMessage() . "\n";
    }
}

echo "✅ $tokenCount tokens créés!\n";

// Résumé final
echo "\n" . str_repeat("=", 60) . "\n";
echo "📊 RÉSUMÉ DU REMPLISSAGE\n";
echo str_repeat("=", 60) . "\n";

$counts = [
    'Utilisateurs' => $db->query("SELECT COUNT(*) FROM users")->fetchColumn(),
    'Catégories' => $db->query("SELECT COUNT(*) FROM categories")->fetchColumn(),
    'Produits' => $db->query("SELECT COUNT(*) FROM products")->fetchColumn(),
    'Commandes' => $db->query("SELECT COUNT(*) FROM orders")->fetchColumn(),
    'Articles commande' => $db->query("SELECT COUNT(*) FROM order_items")->fetchColumn(),
    'Tokens reset' => $db->query("SELECT COUNT(*) FROM password_reset_tokens")->fetchColumn(),
];

foreach ($counts as $name => $count) {
    printf("%-25s: %3d\n", $name, $count);
}

echo str_repeat("=", 60) . "\n";
echo "\n✅ BD COMPLÈTEMENT REMPLIE!\n";
echo "🚀 Prêt pour les tests!\n";
echo "🌐 Accueil: http://localhost:8000\n";
echo "👤 Admin: admin@novashop.local / password123\n";
echo "👤 User: user@novashop.local / password123\n";

?>
