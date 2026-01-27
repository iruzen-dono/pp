<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AuthMiddleware;
use App\Models\Product;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../Models/Product.php';

class CartController extends Controller
{
    public function index()
    {
        AuthMiddleware::check();

        $cart = $_SESSION['cart'] ?? [];
        $products = [];
        $total = 0;

        if (!empty($cart)) {
            $productModel = new Product();

            foreach ($cart as $productId => $item) {
                $product = $productModel->getById($productId);

                if ($product) {
                    $product['quantity'] = $item['quantity'];
                    $product['subtotal'] = $item['quantity'] * $item['price'];
                    $total += $product['subtotal'];
                    $products[] = $product;
                }
            }
        }

        $this->view('cart/index', [
            'products' => $products,
            'total' => $total
        ]);
    }

    public function add()
    {
        AuthMiddleware::check();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /cart");
            exit;
        }

        $productId = (int)($_POST['product_id'] ?? 0);
        $quantity  = (int)($_POST['quantity'] ?? 1);

        if ($productId <= 0 || $quantity <= 0) {
            header("Location: /");
            exit;
        }

        $productModel = new Product();
        $product = $productModel->getById($productId);

        // Produit inexistant
        if (!$product) {
            header("Location: /");
            exit;
        }

        // Initialisation panier
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = [
                'quantity' => $quantity,
                'price' => $product['price']
            ];
        }

        header("Location: /cart");
        exit;
    }

    public function remove()
    {
        AuthMiddleware::check();

        $productId = (int)($_GET['id'] ?? 0);

        if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        header("Location: /cart");
        exit;
    }
}
