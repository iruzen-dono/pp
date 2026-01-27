<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AdminMiddleware;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Middleware/AdminMiddleware.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Order.php';

class AdminController extends Controller
{
    public function __construct()
    {
        AdminMiddleware::check();
    }

    public function dashboard()
    {
        $userModel = new User();
        $productModel = new Product();
        $orderModel = new Order();

        $stats = [
            'users_count'    => count($userModel->getAll()),
            'products_count' => count($productModel->getAll()),
            'orders_count'   => count($orderModel->getAll())
        ];

        $this->adminView('admin/dashboard', $stats);
    }

    public function users()
    {
        $users = (new User())->getAll();
        $this->adminView('admin/users', compact('users'));
    }

    public function products()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (($_POST['action'] ?? '') === 'create') {

                $imagePath = null;

                if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

                    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
                    finfo_close($finfo);

                    if (!in_array($mime, $allowedMimes)) {
                        header('Location: /admin/products?error=invalid_image');
                        exit;
                    }

                    if ($_FILES['image']['size'] > 5 * 1024 * 1024) {
                        header('Location: /admin/products?error=image_too_large');
                        exit;
                    }

                    $uploadDir = dirname(__DIR__, 2) . '/public/assets/images/products/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $fileName = uniqid('product_', true) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName);

                    $imagePath = '/assets/images/products/' . $fileName;
                }

                (new Product())->create([
                    'name'        => trim($_POST['name'] ?? ''),
                    'description' => trim($_POST['description'] ?? ''),
                    'image_url'   => $imagePath,
                    'price'       => (float)($_POST['price'] ?? 0),
                    'category_id' => (int)($_POST['category_id'] ?? 1),
                    'stock'       => (int)($_POST['stock'] ?? 0)
                ]);

                header('Location: /admin/products?success=1');
                exit;
            }
        }

        $products = (new Product())->getAll();
        $this->adminView('admin/products', compact('products'));
    }

    public function orders()
    {
        $orders = (new Order())->getAll();
        $this->adminView('admin/orders', compact('orders'));
    }

    public function deleteUser()
    {
        $userId = (int)($_GET['params'][0] ?? 0);

        if ($userId <= 0 || $userId === ($_SESSION['user']['id'] ?? 0)) {
            header('Location: /admin/users?error=invalid');
            exit;
        }

        (new User())->delete($userId);
        header('Location: /admin/users?success=deleted');
        exit;
    }

    public function deleteProduct()
    {
        $id = (int)($_GET['params'][0] ?? 0);
        if ($id > 0) {
            (new Product())->delete($id);
        }
        header('Location: /admin/products');
        exit;
    }

    public function deleteOrder()
    {
        $id = (int)($_GET['params'][0] ?? 0);
        if ($id > 0) {
            (new Order())->delete($id);
        }
        header('Location: /admin/orders');
        exit;
    }
}
