<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Middleware\AuthMiddleware;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Middleware/AuthMiddleware.php';
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/OrderItem.php';

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

        // Calcul du total avec support pour les variantes
        $total = 0;
        foreach ($cart as $productId => $item) {
            if (isset($item['variants']) && is_array($item['variants'])) {
                // New structure with variants
                foreach ($item['variants'] as $variantName => $vdata) {
                    $quantity = (int)($vdata['quantity'] ?? 1);
                    $price = (float)($vdata['price'] ?? 0);
                    $total += $quantity * $price;
                }
            } elseif (isset($item['quantity'])) {
                // Legacy structure
                $total += (int)$item['quantity'] * (float)($item['price'] ?? 0);
            } elseif (is_numeric($item)) {
                // Very old format
                $total += (int)$item;
            }
        }

        $orderModel = new Order();
        $orderItemModel = new OrderItem();

        $orderId = $orderModel->create($_SESSION['user']['id'], $total);

        foreach ($cart as $productId => $item) {
            if (isset($item['variants']) && is_array($item['variants'])) {
                // For variants, create an item for each variant
                foreach ($item['variants'] as $variantName => $vdata) {
                    $quantity = (int)($vdata['quantity'] ?? 1);
                    $price = (float)($vdata['price'] ?? 0);
                    $orderItemModel->create(
                        $orderId,
                        $productId,
                        $quantity,
                        $price
                    );
                }
            } else {
                // Legacy format
                $orderItemModel->create(
                    $orderId,
                    $productId,
                    $item['quantity'] ?? 1,
                    $item['price'] ?? 0
                );
            }
        }

        unset($_SESSION['cart']);

        header("Location: /orders/show?id=" . $orderId);
        exit;
    }
}
