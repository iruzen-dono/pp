<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Middleware\AuthMiddleware;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/OrderItem.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';

class OrderController extends Controller
{
    public function index()
    {
        AuthMiddleware::check();

        $orderModel = new Order();
        $orders = $orderModel->getByUserId($_SESSION['user']['id']);

        $this->view('orders/index', compact('orders'));
    }

    public function show()
    {
        AuthMiddleware::check();

        $orderId = (int)($_GET['id'] ?? 0);
        if ($orderId <= 0) {
            header("Location: /orders");
            exit;
        }

        $orderModel = new Order();
        $order = $orderModel->getById($orderId);

        if (!$order || $order['user_id'] !== $_SESSION['user']['id']) {
            http_response_code(404);
            die("Commande introuvable");
        }

        $orderItemModel = new OrderItem();
        $items = $orderItemModel->getByOrderId($orderId);

        $this->view('orders/show', compact('order', 'items'));
    }

    public function create()
    {
        AuthMiddleware::check();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /cart");
            exit;
        }

        $cart = $_SESSION['cart'] ?? [];

        if (empty($cart)) {
            header("Location: /cart");
            exit;
        }

        // Calcul du total à partir du panier
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        $orderModel = new Order();
        $orderItemModel = new OrderItem();

        // Création de la commande
        $orderId = $orderModel->create($_SESSION['user']['id'], $total);

        // Création des items
        foreach ($cart as $productId => $item) {
            $orderItemModel->create(
                $orderId,
                $productId,
                $item['quantity'],
                $item['price']
            );
        }

        // Vider le panier
        unset($_SESSION['cart']);

        header("Location: /orders/show?id=" . $orderId);
        exit;
    }
}
