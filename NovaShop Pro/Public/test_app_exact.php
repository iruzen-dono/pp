<?php
header('Content-Type: text/plain; charset=utf-8');

// SIMULATION EXACTE DE L'APPLICATION

echo "SIMULATION EXACTE DE L'APP\n";
echo "==========================\n\n";

session_start();

// Autoload exactement comme dans index.php
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../' . $class . '.php';
    
    echo "[AUTOLOAD] Chargement: $class -> $file\n";
    
    if (file_exists($file)) {
        require_once $file;
        echo "  ✅ Fichier trouvé\n";
    } else {
        echo "  ❌ Fichier NON trouvé\n";
    }
});

echo "\nChargement des classes...\n";
require_once __DIR__ . '/../App/Config/Database.php';
require_once __DIR__ . '/../App/Core/Model.php';
require_once __DIR__ . '/../App/Models/Product.php';

use App\Models\Product;

echo "\nTest du modèle Product:\n";
$product = new Product();
$products = $product->getAll();

echo "\nRésultat: " . count($products) . " produits\n";

if (empty($products)) {
    echo "❌ PROBLÈME! Le modèle retourne vide!\n";
    
    // Débugage supplémentaire
    echo "\nDébugage:\n";
    $db = \App\Config\Database::getConnection();
    
    // Test direct sur la connexion
    $stmt = $db->query("SELECT COUNT(*) FROM products");
    $count = $stmt->fetchColumn();
    echo "COUNT direct: " . $count . "\n";
    
} else {
    echo "✅ Ça fonctionne!\n";
    echo "Premier produit: " . $products[0]['name'] . "\n";
}
