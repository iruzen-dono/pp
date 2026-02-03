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

        $productModel = new Product();

        foreach ($cart as $productId => $item) {
            $product = $productModel->getById((int)$productId);
            if (!$product) {
                continue;
            }

            // New structure: ['variants' => ['VariantName' => ['quantity'=>x,'price'=>y], ...]]
            if (isset($item['variants']) && is_array($item['variants'])) {
                foreach ($item['variants'] as $variantName => $vdata) {
                    $row = $product;
                    $row['variant'] = $variantName;
                    $row['quantity'] = (int)($vdata['quantity'] ?? 1);
                    $row['subtotal'] = $row['quantity'] * (float)($vdata['price'] ?? $product['price']);
                    $total += $row['subtotal'];
                    $products[] = $row;
                }
            } elseif (isset($item['quantity'])) {
                // Legacy support: product => ['quantity'=>x,'price'=>y]
                $product['quantity'] = (int)$item['quantity'];
                $product['subtotal'] = $product['quantity'] * (float)($item['price'] ?? $product['price']);
                $total += $product['subtotal'];
                $products[] = $product;
            } elseif (is_numeric($item)) {
                // Very old format: productId => quantity
                $product['quantity'] = (int)$item;
                $product['subtotal'] = $product['quantity'] * $product['price'];
                $total += $product['subtotal'];
                $products[] = $product;
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
        $variant = trim((string)($_POST['variant'] ?? 'Standard')) ?: 'Standard';

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

        if (!isset($_SESSION['cart'][$productId]) || !is_array($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] = ['variants' => []];
        }

        if (!isset($_SESSION['cart'][$productId]['variants'][$variant])) {
            $_SESSION['cart'][$productId]['variants'][$variant] = [
                'quantity' => $quantity,
                'price' => $product['price']
            ];
        } else {
            $_SESSION['cart'][$productId]['variants'][$variant]['quantity'] += $quantity;
        }

        header("Location: /cart");
        exit;
    }

    public function remove()
    {
        AuthMiddleware::check();

        $productId = (int)($_GET['id'] ?? 0);
        $variant = $_GET['variant'] ?? null;

        if ($productId > 0 && isset($_SESSION['cart'][$productId])) {
            if ($variant && isset($_SESSION['cart'][$productId]['variants'][$variant])) {
                unset($_SESSION['cart'][$productId]['variants'][$variant]);
                // If no variants remain, remove the product entry
                if (empty($_SESSION['cart'][$productId]['variants'])) {
                    unset($_SESSION['cart'][$productId]);
                }
            } else {
                unset($_SESSION['cart'][$productId]);
            }
        }

        header("Location: /cart");
        exit;
    }
}
