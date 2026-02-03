<?php
// Test simple de récupération des produits, sans HTML
header('Content-Type: application/json');

require_once __DIR__ . '/../App/Config/Database.php';
require_once __DIR__ . '/../App/Core/Model.php';
require_once __DIR__ . '/../App/Models/Product.php';

use App\Models\Product;

try {
    $product = new Product();
    $products = $product->getAll();
    
    echo json_encode([
        'success' => true,
        'count' => count($products),
        'sample' => array_slice($products, 0, 3),
        'type' => gettype($products)
    ], JSON_PRETTY_PRINT);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ], JSON_PRETTY_PRINT);
}
