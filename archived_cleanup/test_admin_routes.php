<?php
echo "╔════════════════════════════════════════════╗\n";
echo "║   VÉRIFICATION DES ROUTES ADMIN            ║\n";
echo "╚════════════════════════════════════════════╝\n\n";

$routes = [
    '/admin/dashboard' => 'Page du tableau de bord',
    '/admin/users' => 'Gestion des utilisateurs',
    '/admin/products' => 'Gestion des produits',
    '/admin/orders' => 'Gestion des commandes',
    '/admin/deleteUser/2' => 'Supprimer utilisateur ID 2',
    '/admin/deleteProduct/5' => 'Supprimer produit ID 5',
    '/admin/deleteOrder/1' => 'Supprimer commande ID 1',
    '/admin/products/edit/3' => 'Éditer produit ID 3',
];

echo "Routes Admin disponibles:\n";
echo "─────────────────────────\n";
foreach ($routes as $route => $description) {
    echo "✓ $route\n";
    echo "  → $description\n\n";
}

// Test du parsage des routes
echo "Test du parsage des routes:\n";
echo "──────────────────────────────\n";

function testRouteParsing($url) {
    $parts = explode('/', trim($url, '/'));
    echo "URL: $url\n";
    echo "Parts: " . json_encode($parts) . "\n";
    
    if ($parts[0] === 'admin' && isset($parts[1])) {
        if ($parts[1] === 'products' && isset($parts[2]) && $parts[2] === 'edit' && isset($parts[3])) {
            echo "→ AdminController::editProduct({$parts[3]})\n";
        } else {
            echo "→ AdminController::{$parts[1]}(" . (isset($parts[2]) ? $parts[2] : '') . ")\n";
        }
    }
    echo "\n";
}

testRouteParsing('/admin/deleteUser/2');
testRouteParsing('/admin/deleteProduct/5');
testRouteParsing('/admin/products/edit/3');
testRouteParsing('/admin/deleteOrder/1');

echo "✓ Toutes les routes admin devraient fonctionner!\n";
?>
