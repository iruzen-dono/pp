<?php
namespace App\Controllers;

require_once __DIR__ . '/../Core/Controller.php';

use App\Core\Controller;

class CartController extends Controller
{
    public function index()
    {
        $this->view('cart/index');
    }

    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }

            $productId = $_POST['product_id'] ?? null;
            $quantity = (int)($_POST['quantity'] ?? 1);

            if ($productId && $quantity > 0) {
                if (isset($_SESSION['cart'][$productId])) {
                    $_SESSION['cart'][$productId] += $quantity;
                } else {
                    $_SESSION['cart'][$productId] = $quantity;
                }
            }

            header("Location: /cart");
            exit;
        }
    }

    public function remove()
    {
        $productId = $_GET['id'] ?? null;

        if ($productId && isset($_SESSION['cart'][$productId])) {
            unset($_SESSION['cart'][$productId]);
        }

        header("Location: /cart");
        exit;
    }
}
