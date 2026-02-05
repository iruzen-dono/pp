<?php
header('Content-Type: text/plain; charset=utf-8');

echo "TEST AVEC CLASSE DATABASE EXACTEMENT\n";
echo "====================================\n\n";

// Réplique exactement l'autoload du système
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

echo "1. Connexion via Database::getConnection()\n";
try {
    $db = \App\Config\Database::getConnection();
    echo "   ✅ Connexion établie\n";
} catch (Exception $e) {
    echo "   ❌ Erreur: " . $e->getMessage() . "\n";
    die();
}

echo "\n2. Requête SELECT COUNT\n";
$stmt = $db->prepare("SELECT COUNT(*) FROM products");
$stmt->execute();
$count = $stmt->fetchColumn();
echo "   Résultat: " . $count . "\n";

echo "\n3. Requête SELECT *\n";
$stmt = $db->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "   Résultat: " . count($result) . " produits\n";

if (count($result) > 0) {
    echo "   Premier: " . $result[0]['name'] . "\n";
}

echo "\n4. Maintenant tester via le modèle\n";
try {
    $product = new \App\Models\Product();
    $products = $product->getAll();
    echo "   Résultat modèle: " . count($products) . " produits\n";
} catch (Exception $e) {
    echo "   ❌ Erreur: " . $e->getMessage() . "\n";
}
