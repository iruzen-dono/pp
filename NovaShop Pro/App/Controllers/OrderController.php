<?php
namespace App\Controllers;

require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../middleware/AuthMiddleware.php';

use App\Core\Controller;
use App\Models\Order;
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

        $orderId = $_GET['id'] ?? null;

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
            $orderModel = new Order();
            $orderId = $orderModel->create($_SESSION['user']['id']);

            header("Location: /orders/show?id=$orderId");
            exit;
        }

        $this->view('orders/create');
    }
}
