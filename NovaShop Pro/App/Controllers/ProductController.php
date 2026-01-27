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
        $products = (new Product())->getAll();
        $this->view('products/index', compact('products'));
    }

    public function show()
    {
        $productId = (int)($_GET['params'][0] ?? $_GET['id'] ?? 0);

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
