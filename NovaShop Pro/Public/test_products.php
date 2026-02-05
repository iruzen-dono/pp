<?php
// Test direct - affiche les produits bruts depuis la base
require_once __DIR__ . '/App/Config/Database.php';
require_once __DIR__ . '/App/Models/Product.php';

use App\Models\Product;

$productModel = new Product();
$products = $productModel->getAll();

echo "<h1>Test: Produits depuis la base</h1>";
echo "<p>Total: " . count($products) . " produits</p>";

if (!empty($products)) {
    echo "<ul>";
    foreach ($products as $product) {
        echo "<li>" . htmlspecialchars($product['name']) . " - " . $product['price'] . "€</li>";
    }
    echo "</ul>";
} else {
    echo "<p style='color: red;'>❌ Aucun produit trouvé!</p>";
}

// Debug: affiche le type et la structure
echo "<hr>";
echo "<pre>";
echo "Type: " . gettype($products) . "\n";
echo "Structure du premier produit:\n";
var_dump($products[0] ?? []);
echo "</pre>";
