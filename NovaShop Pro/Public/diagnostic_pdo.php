<?php
// Diagnostic détaillé de la connexion PDO
header('Content-Type: text/plain; charset=utf-8');

echo "=== DIAGNOSTIC DÉTAILLÉ NOVASHOP ===\n\n";

// 1. Test de connexion directe
echo "1️⃣ TEST CONNEXION PDO DIRECTE\n";
echo "----------------------------\n";
try {
    $pdo = new PDO(
        'mysql:host=localhost;dbname=novashop_db;charset=utf8mb4',
        'root',
        '0000'
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "✅ Connexion PDO établie\n";
} catch (PDOException $e) {
    echo "❌ Erreur PDO: " . $e->getMessage() . "\n";
    die();
}

// 2. Test SELECT simple
echo "\n2️⃣ TEST SELECT SIMPLE\n";
echo "----------------------------\n";
try {
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM products");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Total produits en base: " . $result['total'] . "\n";
} catch (PDOException $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

// 3. Test SELECT * avec fetchAll
echo "\n3️⃣ TEST SELECT * AVEC FETCHALL\n";
echo "----------------------------\n";
try {
    $stmt = $pdo->query("SELECT * FROM products LIMIT 3");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Produits récupérés: " . count($products) . "\n";
    if (!empty($products)) {
        echo "Premier produit: " . json_encode($products[0], JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (PDOException $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

// 4. Test avec prepare() et execute()
echo "\n4️⃣ TEST AVEC PREPARE/EXECUTE\n";
echo "----------------------------\n";
try {
    $stmt = $pdo->prepare("SELECT * FROM products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Produits récupérés: " . count($products) . "\n";
} catch (PDOException $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

// 5. Test de la classe Database
echo "\n5️⃣ TEST CLASSE DATABASE\n";
echo "----------------------------\n";
try {
    require_once __DIR__ . '/../App/Config/Database.php';
    $db = \App\Config\Database::getConnection();
    echo "✅ Connexion via classe Database établie\n";
    
    // Teste la méthode getConnection
    $stmt = $db->query("SELECT COUNT(*) FROM products");
    $count = $stmt->fetchColumn();
    echo "Count via Database class: " . $count . "\n";
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}

// 6. Test du modèle Product directement
echo "\n6️⃣ TEST MODÈLE PRODUCT\n";
echo "----------------------------\n";
try {
    require_once __DIR__ . '/../App/Core/Model.php';
    require_once __DIR__ . '/../App/Models/Product.php';
    
    $product = new \App\Models\Product();
    $products = $product->getAll();
    
    echo "Type retourné: " . gettype($products) . "\n";
    echo "Count: " . count($products) . "\n";
    
    if (is_array($products) && !empty($products)) {
        echo "✅ Modèle fonctionne! Premier produit: " . $products[0]['name'] . "\n";
    } else {
        echo "❌ Le modèle retourne un tableau vide\n";
        echo "DEBUG: " . json_encode($products) . "\n";
    }
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}

echo "\n=== FIN DIAGNOSTIC ===\n";
