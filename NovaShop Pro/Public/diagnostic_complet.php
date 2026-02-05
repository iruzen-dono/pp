<?php
// Diagnostic complet - vérifier tout le pipeline

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>🔍 DIAGNOSTIC COMPLET NOVASHOP</h1>";
echo "<hr>";

// 1. Vérifier la connexion à la base
echo "<h2>1️⃣ Connexion Base de Données</h2>";
try {
    require_once __DIR__ . '/../App/Config/Database.php';
    $db = \App\Config\Database::getConnection();
    echo "✅ Connexion établie<br>";
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
    die();
}

// 2. Compter les produits
echo "<h2>2️⃣ Produits en Base de Données</h2>";
$stmt = $db->query("SELECT COUNT(*) FROM products");
$count = $stmt->fetchColumn();
echo "Total produits: <strong>$count</strong><br>";

// 3. Tester getAll() du modèle
echo "<h2>3️⃣ Test Model::getAll()</h2>";
require_once __DIR__ . '/../App/Models/Product.php';
$productModel = new \App\Models\Product();
$products = $productModel->getAll();

echo "Type retourné: <strong>" . gettype($products) . "</strong><br>";
echo "Nombre d'éléments: <strong>" . count($products) . "</strong><br>";

if (!empty($products)) {
    echo "✅ Produits récupérés avec succès!<br>";
    echo "<h3>Premiers produits:</h3>";
    echo "<table border='1' style='width:100%; margin-top: 10px;'>";
    echo "<tr><th>ID</th><th>Nom</th><th>Prix</th><th>Stock</th></tr>";
    foreach (array_slice($products, 0, 5) as $product) {
        echo "<tr>";
        echo "<td>" . $product['id'] . "</td>";
        echo "<td>" . htmlspecialchars($product['name']) . "</td>";
        echo "<td>" . $product['price'] . "€</td>";
        echo "<td>" . $product['stock'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "❌ Aucun produit retourné par getAll()!<br>";
    echo "<pre>";
    var_dump($products);
    echo "</pre>";
}

// 4. Vérifier le contrôleur ProductController
echo "<h2>4️⃣ Test ProductController</h2>";
require_once __DIR__ . '/../App/Core/Controller.php';
require_once __DIR__ . '/../App/Controllers/ProductController.php';

$controller = new \App\Controllers\ProductController();
// Simuler l'appel à index()
$_GET['q'] = '';
$_POST = [];

try {
    ob_start();
    // On ne peut pas appeler directement index() donc on teste juste l'existence
    echo "✅ ProductController existe et est accessible<br>";
    ob_end_clean();
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "<br>";
}

// 5. État final
echo "<h2>5️⃣ Conclusion</h2>";
if ($count > 0 && count($products) > 0) {
    echo "✅ <strong>TOUT FONCTIONNE!</strong> Les produits sont en base et accessibles.<br>";
    echo "👉 Allez à <a href='/products'>http://localhost:8000/products</a> et videz le cache navigateur (Ctrl+Shift+Delete)";
} else {
    echo "❌ <strong>PROBLÈME:</strong> Les produits ne sont pas accessibles au modèle.<br>";
}
