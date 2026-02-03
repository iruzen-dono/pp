<?php
require 'App/Config/Database.php';
use App\Config\Database;

try {
    $pdo = Database::getConnection();
    
    echo "╔══════════════════════════════════════════════════════════╗\n";
    echo "║           VÉRIFICATION DES CHEMINS D'IMAGES              ║\n";
    echo "╚══════════════════════════════════════════════════════════╝\n\n";
    
    // Récupérer les produits
    $stmt = $pdo->query("SELECT id, name, image_url FROM products LIMIT 5");
    $products = $stmt->fetchAll();
    
    foreach ($products as $p) {
        echo "Produit: {$p['name']}\n";
        echo "─────────────────────────────────────────\n";
        
        echo "URL en base:        {$p['image_url']}\n";
        
        // Chemin absolu depuis la racine du projet
        $absolute_path = __DIR__ . '/Public' . $p['image_url'];
        echo "Chemin absolu:      $absolute_path\n";
        echo "Fichier existe:     " . (file_exists($absolute_path) ? "✓ OUI" : "✗ NON") . "\n";
        
        // Vérifier les permissions
        if (file_exists($absolute_path)) {
            echo "Lisible:            " . (is_readable($absolute_path) ? "✓ OUI" : "✗ NON") . "\n";
            echo "Taille:             " . filesize($absolute_path) . " octets\n";
        }
        
        echo "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erreur: " . $e->getMessage();
}
?>
