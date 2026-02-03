<?php
require 'App/Config/Database.php';
use App\Config\Database;

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query('SELECT id, name, image_url FROM products');
    $products = $stmt->fetchAll();
    
    echo "=== Analyse des URLs d'images ===\n\n";
    
    $missing = [];
    $hasUrl = [];
    $null = [];
    
    foreach($products as $p) {
        if (empty($p['image_url'])) {
            $null[] = $p;
        } else {
            $hasUrl[] = $p;
            // Vérifier si le fichier existe
            $path = __DIR__ . '/Public' . $p['image_url'];
            if (!file_exists($path)) {
                $missing[] = $p;
            }
        }
    }
    
    echo "Total produits: " . count($products) . "\n";
    echo "Produits avec URL: " . count($hasUrl) . "\n";
    echo "Produits sans URL (NULL): " . count($null) . "\n";
    echo "URLs pointant vers des fichiers manquants: " . count($missing) . "\n\n";
    
    if (count($null) > 0) {
        echo "=== Produits SANS URL ===\n";
        foreach($null as $p) {
            echo "ID: {$p['id']} | {$p['name']}\n";
        }
        echo "\n";
    }
    
    if (count($missing) > 0) {
        echo "=== Produits avec URL INVALIDE ===\n";
        foreach($missing as $p) {
            echo "ID: {$p['id']} | {$p['name']} | URL: {$p['image_url']}\n";
        }
        echo "\n";
    }
    
    echo "=== Images disponibles dans /Public/Assets/Images/products ===\n";
    $images = scandir(__DIR__ . '/Public/Assets/Images/products');
    $images = array_filter($images, fn($f) => $f !== '.' && $f !== '..');
    echo "Nombre d'images: " . count($images) . "\n";
    foreach(array_slice($images, 0, 10) as $img) {
        echo "  - $img\n";
    }
    if (count($images) > 10) {
        echo "  ... et " . (count($images) - 10) . " autres\n";
    }
    
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
?>
