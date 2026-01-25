<?php
namespace App\Controllers;

require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/OrderItem.php';
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

use App\Core\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderItem;
use App\Middleware\AuthMiddleware;

class OrderController extends Controller
{
    public function index()
    {
        AuthMiddleware::check();

        if (isset($_SESSION['user'])) {
            $orderModel = new Order();
            $orders = $orderModel->getByUserId($_SESSION['user']['id']);
            $this->view('orders/index', compact('orders'));
        }
    }

    public function show()
    {
        AuthMiddleware::check();

        $orderId = $_GET['id'] ?? $_GET['params'][0] ?? null;

        if (!$orderId) {
            header("Location: /orders");
            exit;
        }

        $orderModel = new Order();
        $order = $orderModel->getById($orderId);

        if (!$order || $order['user_id'] != $_SESSION['user']['id']) {
            die("❌ Commande non trouvée");
        }

        $this->view('orders/show', compact('order'));
    }

    public function create()
    {
        AuthMiddleware::check();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Calculer le total du panier
            $cart = $_SESSION['cart'] ?? [];
            $total = 0;
            $productModel = new Product();
            
            if (!empty($cart)) {
                foreach ($cart as $productId => $quantity) {
                    $product = $productModel->getById($productId);
                    if ($product) {
                        $total += (float)$product['price'] * (int)$quantity;
                    }
                }
            }
            
            $orderModel = new Order();
            $orderId = $orderModel->create($_SESSION['user']['id'], $total);
            
            // Créer les items de la commande
            $orderItemModel = new OrderItem();
            
            foreach ($cart as $productId => $quantity) {
                $product = $productModel->getById($productId);
                if ($product) {
                    $orderItemModel->create($orderId, $productId, $quantity, $product['price']);
                }
            }
            
            // Vider le panier
            unset($_SESSION['cart']);

            header("Location: /order/$orderId");
            exit;
        }

        $this->view('orders/create');
    }
}
