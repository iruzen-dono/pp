<?php
require 'App/Config/Database.php';
use App\Config\Database;

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query('SELECT id, name, image_url FROM products LIMIT 10');
    $products = $stmt->fetchAll();
    
    echo "=== Exemples d'URLs en base de données ===\n\n";
    
    foreach($products as $p) {
        echo "ID: {$p['id']} | Nom: {$p['name']}\n";
        echo "  URL: {$p['image_url']}\n";
        
        $path = __DIR__ . '/Public' . $p['image_url'];
        $exists = file_exists($path) ? "✓ EXISTS" : "✗ MANQUANT";
        echo "  Chemin: $path\n";
        echo "  Statut: $exists\n\n";
    }
    
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
?>
