<?php
require 'App/Config/Database.php';
use App\Config\Database;

try {
    $pdo = Database::getConnection();
    
    echo "╔════════════════════════════════════════════════════════════╗\n";
    echo "║     ANALYSE COMPLÈTE DE LA BASE DE DONNÉES NOVASHOP        ║\n";
    echo "╚════════════════════════════════════════════════════════════╝\n\n";
    
    // 1. Statistiques générales
    echo "📊 STATISTIQUES GÉNÉRALES\n";
    echo "─────────────────────────\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM users");
    $users_count = $stmt->fetch()['count'];
    echo "✓ Utilisateurs: $users_count\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products");
    $products_count = $stmt->fetch()['count'];
    echo "✓ Produits: $products_count\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM categories");
    $categories_count = $stmt->fetch()['count'];
    echo "✓ Catégories: $categories_count\n";
    
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM orders");
    $orders_count = $stmt->fetch()['count'];
    echo "✓ Commandes: $orders_count\n\n";
    
    // 2. Problèmes de données
    echo "⚠️  PROBLÈMES POTENTIELS\n";
    echo "─────────────────────────\n";
    
    // Produits sans catégorie
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products WHERE category_id IS NULL OR category_id = 0");
    $no_cat = $stmt->fetch()['count'];
    if ($no_cat > 0) {
        echo "⚠️  $no_cat produit(s) SANS catégorie\n";
    }
    
    // Produits avec stock 0
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products WHERE stock <= 0");
    $no_stock = $stmt->fetch()['count'];
    echo "⚠️  $no_stock produit(s) avec STOCK = 0 ou négatif\n";
    
    // Produits sans image
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products WHERE image_url IS NULL OR image_url = ''");
    $no_image = $stmt->fetch()['count'];
    echo "⚠️  $no_image produit(s) SANS image\n";
    
    // Produits sans description
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products WHERE description IS NULL OR description = ''");
    $no_desc = $stmt->fetch()['count'];
    echo "⚠️  $no_desc produit(s) SANS description\n";
    
    // Catégories sans produits
    $stmt = $pdo->query("SELECT COUNT(DISTINCT c.id) as count FROM categories c LEFT JOIN products p ON c.id = p.category_id WHERE p.id IS NULL");
    $empty_cat = $stmt->fetch()['count'];
    echo "⚠️  $empty_cat catégorie(s) VIDE (sans produits)\n";
    
    // Commandes sans articles
    $stmt = $pdo->query("SELECT COUNT(DISTINCT o.id) as count FROM orders o LEFT JOIN order_items oi ON o.id = oi.order_id WHERE oi.id IS NULL");
    $empty_orders = $stmt->fetch()['count'];
    echo "⚠️  $empty_orders commande(s) VIDE (sans articles)\n";
    
    // Utilisateurs sans commandes
    $stmt = $pdo->query("SELECT COUNT(DISTINCT u.id) as count FROM users u LEFT JOIN orders o ON u.id = o.user_id WHERE o.id IS NULL");
    $no_orders = $stmt->fetch()['count'];
    echo "ℹ️  $no_orders utilisateur(s) SANS commande\n\n";
    
    // 3. Détails des produits problématiques
    echo "🔍 DÉTAILS DES PROBLÈMES\n";
    echo "─────────────────────────\n";
    
    if ($no_stock > 0) {
        echo "\nProduits avec stock insuffisant:\n";
        $stmt = $pdo->query("SELECT id, name, stock FROM products WHERE stock <= 0 LIMIT 10");
        foreach ($stmt->fetchAll() as $p) {
            echo "  - ID {$p['id']}: {$p['name']} (stock: {$p['stock']})\n";
        }
        if ($no_stock > 10) {
            echo "  ... et " . ($no_stock - 10) . " autres\n";
        }
    }
    
    if ($no_cat > 0) {
        echo "\nProduits sans catégorie:\n";
        $stmt = $pdo->query("SELECT id, name FROM products WHERE category_id IS NULL OR category_id = 0 LIMIT 10");
        foreach ($stmt->fetchAll() as $p) {
            echo "  - ID {$p['id']}: {$p['name']}\n";
        }
    }
    
    // 4. Vérification des images manquantes
    echo "\n📁 VÉRIFICATION DES IMAGES\n";
    echo "─────────────────────────────\n";
    
    $stmt = $pdo->query("SELECT id, name, image_url FROM products WHERE image_url IS NOT NULL AND image_url != ''");
    $all_products = $stmt->fetchAll();
    
    $missing_images = [];
    foreach ($all_products as $p) {
        $path = __DIR__ . '/Public' . $p['image_url'];
        if (!file_exists($path)) {
            $missing_images[] = $p;
        }
    }
    
    if (count($missing_images) > 0) {
        echo "⚠️  " . count($missing_images) . " fichier(s) d'image MANQUANT:\n";
        foreach ($missing_images as $p) {
            echo "  - {$p['image_url']}\n";
        }
    } else {
        echo "✓ Toutes les images sont présentes!\n";
    }
    
    // 5. Intégrité referentielle
    echo "\n🔗 INTÉGRITÉ REFERENTIELLE\n";
    echo "──────────────────────────────\n";
    
    // Produits avec category_id invalide
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM products WHERE category_id IS NOT NULL AND category_id NOT IN (SELECT id FROM categories)");
    $bad_cat = $stmt->fetch()['count'];
    if ($bad_cat > 0) {
        echo "⚠️  $bad_cat produit(s) avec category_id invalide\n";
    } else {
        echo "✓ Toutes les catégories de produits sont valides\n";
    }
    
    // Orders avec user_id invalide
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM orders WHERE user_id NOT IN (SELECT id FROM users)");
    $bad_user = $stmt->fetch()['count'];
    if ($bad_user > 0) {
        echo "⚠️  $bad_user commande(s) avec user_id invalide\n";
    } else {
        echo "✓ Toutes les commandes ont un utilisateur valide\n";
    }
    
    // OrderItems avec product_id invalide
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM order_items WHERE product_id NOT IN (SELECT id FROM products)");
    $bad_product = $stmt->fetch()['count'];
    if ($bad_product > 0) {
        echo "⚠️  $bad_product article(s) de commande avec product_id invalide\n";
    } else {
        echo "✓ Tous les articles de commande ont un produit valide\n";
    }
    
    echo "\n";
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}
?>
