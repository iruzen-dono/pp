<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Product.php';

class ProductController extends Controller
{
    public function index()
    {
        $searchQuery = $_GET['q'] ?? $_POST['q'] ?? '';
        $products = [];
        
        try {
            if (!empty($searchQuery)) {
                // Utiliser la recherche si une requête est fournie
                $products = (new Product())->search($searchQuery);
            } else {
                // Sinon afficher tous les produits
                $products = (new Product())->getAll();
            }
            
            // S'assurer que $products est toujours un array
            if (!is_array($products)) {
                $products = [];
            }
        } catch (\Exception $e) {
            // En cas d'erreur, on garde le tableau vide
            $products = [];
            error_log("Erreur ProductController::index(): " . $e->getMessage());
        }
        
        $this->view('products/index', compact('products', 'searchQuery'));
    }

    public function show($productId = null)
    {
        // Get product ID from parameter or GET
        if ($productId === null) {
            $productId = (int)($_GET['id'] ?? 0);
        } else {
            $productId = (int)$productId;
        }

        if ($productId <= 0) {
            header("Location: /products");
            exit;
        }

        $product = (new Product())->getById($productId);

        if (!$product) {
            http_response_code(404);
            die("Produit introuvable");
        }

        $this->view('products/show', compact('product'));
    }
}
