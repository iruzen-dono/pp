<?php
namespace App\Controllers;

require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Core/Controller.php';

use App\Core\Controller;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $productModel = new Product();
        $products = $productModel->getAll();
        $this->view('products/index', compact('products'));
    }

    public function show()
    {
        $productId = $_GET['params'][0] ?? $_GET['id'] ?? null;

        if (!$productId) {
            header("Location: /products");
            exit;
        }

        $productModel = new Product();
        $product = $productModel->getById($productId);

        if (!$product) {
            die("❌ Produit non trouvé (ID: $productId)");
        }

        $this->view('products/show', compact('product'));
    }
}
