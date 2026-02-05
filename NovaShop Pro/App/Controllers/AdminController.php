<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Middleware\AdminMiddleware;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Middleware/AdminMiddleware.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Order.php';
require_once __DIR__ . '/../Models/OrderItem.php';
require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';

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
        $sortBy = $_GET['sort'] ?? 'created_at';
        $sortOrder = $_GET['order'] ?? 'DESC';
        $users = (new User())->getAll($sortBy, $sortOrder);
        $this->adminView('admin/users', compact('users', 'sortBy', 'sortOrder'));
    }

    public function products()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            \App\Middleware\CsrfMiddleware::checkPost();

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

                    $uploadDir = dirname(__DIR__, 2) . '/Public/Assets/Images/products/';
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }

                    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                    $allowedExt = ['jpg','jpeg','png','webp','gif'];
                    if (!in_array($ext, $allowedExt)) {
                        header('Location: /admin/products?error=invalid_image');
                        exit;
                    }

                    $fileName = uniqid('product_', true) . '.' . $ext;
                    move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName);

                    $imagePath = '/Assets/Images/products/' . $fileName;
                }

                (new Product())->create([
                    'name'        => trim($_POST['name'] ?? ''),
                    'description' => trim($_POST['description'] ?? ''),
                    'image_url'   => $imagePath,
                    'price'       => (float)($_POST['price'] ?? 0),
                    'category_id' => (int)($_POST['category_id'] ?? 1),
                    'stock'       => (int)($_POST['stock'] ?? 0),
                    'variants'    => trim($_POST['variants'] ?? '')
                ]);

                header('Location: /admin/products?success=1');
                exit;
            }
        }

        $productModel = new Product();
        $search = trim($_GET['search'] ?? '');
        $category = (int)($_GET['category'] ?? 0);
        
        if ($search !== '' || $category > 0) {
            $products = $productModel->search($search, $category);
        } else {
            $products = $productModel->getAll();
        }
        
        $this->adminView('admin/products', compact('products', 'search', 'category'));
    }

    public function orders()
    {
        $orders = (new Order())->getAll();
        $this->adminView('admin/orders', compact('orders'));
    }

    public function order($orderId = null)
    {
        if ($orderId === null) {
            $orderId = (int)($_GET['params'][0] ?? 0);
        } else {
            $orderId = (int)$orderId;
        }

        if ($orderId <= 0) {
            header("Location: /admin/orders");
            exit;
        }

        $orderModel = new Order();
        $order = $orderModel->getById($orderId);

        if (!$order) {
            http_response_code(404);
            die("Commande introuvable");
        }

        $orderItemModel = new OrderItem();
        $items = $orderItemModel->getByOrderId($orderId);

        $this->adminView('admin/order-detail', compact('order', 'items'));
    }

    public function updateOrderStatus($orderId = null)
    {
        // Only admin and super_admin can update order status
        AdminMiddleware::check();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location: /admin/orders");
            exit;
        }

        \App\Middleware\CsrfMiddleware::checkPost();

        if ($orderId === null) {
            $orderId = (int)($_GET['params'][0] ?? 0);
        } else {
            $orderId = (int)$orderId;
        }

        if ($orderId <= 0) {
            header('Location: /admin/orders?error=invalid');
            exit;
        }

        $newStatus = trim($_POST['status'] ?? '');
        if (!in_array($newStatus, ['pending', 'completed', 'cancelled'])) {
            header('Location: /admin/orders?error=invalid_status');
            exit;
        }

        $orderModel = new Order();
        $order = $orderModel->getById($orderId);

        if (!$order) {
            header('Location: /admin/orders?error=not_found');
            exit;
        }

        // Update order status
        $orderModel->updateStatus($orderId, $newStatus);

        header('Location: /admin/order/' . $orderId . '?success=status_updated');
        exit;
    }

    public function deleteUser($userId = null)
    {
        // Only super_admin can delete users
        $currentUserRole = $_SESSION['user']['role'] ?? 'user';
        if ($currentUserRole !== 'super_admin') {
            http_response_code(403);
            die('❌ Permission refusée: Seul un super administrateur peut supprimer des utilisateurs.');
        }

        if ($userId === null) {
            $userId = (int)($_GET['params'][0] ?? 0);
        } else {
            $userId = (int)$userId;
        }

        if ($userId <= 0 || $userId === ($_SESSION['user']['id'] ?? 0)) {
            header('Location: /admin/users?error=invalid');
            exit;
        }

        $userModel = new User();
        // Use soft delete (deactivate) instead of hard delete
        $userModel->deactivate($userId);

        header('Location: /admin/users?success=deactivated');
        exit;
    }

    public function reactivateUser($userId = null)
    {
        // Only super_admin can reactivate users
        $currentUserRole = $_SESSION['user']['role'] ?? 'user';
        if ($currentUserRole !== 'super_admin') {
            http_response_code(403);
            die('❌ Permission refusée: Seul un super administrateur peut réactiver des utilisateurs.');
        }

        if ($userId === null) {
            $userId = (int)($_GET['params'][0] ?? 0);
        } else {
            $userId = (int)$userId;
        }

        if ($userId <= 0 || $userId === ($_SESSION['user']['id'] ?? 0)) {
            header('Location: /admin/users?error=invalid');
            exit;
        }

        $userModel = new User();
        $userModel->reactivate($userId);

        header('Location: /admin/users?success=reactivated');
        exit;
    }

    public function changeRole($userId = null)
    {
        // Only super_admin can change roles
        $currentUserRole = $_SESSION['user']['role'] ?? 'user';
        if ($currentUserRole !== 'super_admin') {
            http_response_code(403);
            die('❌ Permission refusée: Seul un super administrateur peut changer les rôles.');
        }

        if ($userId === null) {
            $userId = (int)($_GET['params'][0] ?? 0);
        } else {
            $userId = (int)$userId;
        }

        if ($userId <= 0 || $userId === ($_SESSION['user']['id'] ?? 0)) {
            header('Location: /admin/users?error=invalid');
            exit;
        }

        $newRole = trim($_POST['role'] ?? '');
        if (!in_array($newRole, ['user', 'admin', 'super_admin'])) {
            header('Location: /admin/users?error=invalid_role');
            exit;
        }

        $userModel = new User();
        $userModel->changeRole($userId, $newRole);

        header('Location: /admin/users?success=role_changed');
        exit;
    }

    public function deleteProduct($id = null)
    {
        if ($id === null) {
            $id = (int)($_GET['params'][0] ?? 0);
        } else {
            $id = (int)$id;
        }
        
        if ($id > 0) {
            (new Product())->delete($id);
        }
        header('Location: /admin/products');
        exit;
    }

    public function editProduct($productId = null)
    {
        if ($productId === null) {
            $productId = $_GET['params'][0] ?? null;
        }
        
        if (!$productId) {
            header('Location: /admin/products');
            exit;
        }
        
        $productModel = new Product();
        $product = $productModel->getById($productId);
        
        if (!$product) {
            header('Location: /admin/products?error=not_found');
            exit;
        }
        
        // Traiter la soumission du formulaire
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            \App\Middleware\CsrfMiddleware::checkPost();
            $imagePath = $product['image_url'];
            
            // Gestion de l'upload d'image si une nouvelle image est fournie
            if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image'];
                $uploadDir = __DIR__ . '/../../Public/Assets/Images/products/';
                
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
                
                if (!in_array($mimeType, $allowedMimes)) {
                    header('Location: /admin/products/edit/' . $productId . '?error=invalid_image_type');
                    exit;
                }
                
                if ($file['size'] > 5 * 1024 * 1024) {
                    header('Location: /admin/products/edit/' . $productId . '?error=image_too_large');
                    exit;
                }
                
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
                $allowedExt = ['jpg','jpeg','png','webp','gif'];
                if (!in_array($ext, $allowedExt)) {
                    header('Location: /admin/products/edit/' . $productId . '?error=invalid_image_type');
                    exit;
                }

                $fileName = 'product_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
                $filePath = $uploadDir . $fileName;
                
                if (move_uploaded_file($file['tmp_name'], $filePath)) {
                    $imagePath = '/Assets/Images/products/' . $fileName;
                }
            }
            
            $productModel->update(
                $productId,
                [
                    'name' => $_POST['name'] ?? $product['name'],
                    'description' => $_POST['description'] ?? $product['description'],
                    'price' => (float)($_POST['price'] ?? $product['price']),
                    'category_id' => (int)($_POST['category_id'] ?? $product['category_id']),
                    'stock' => (int)($_POST['stock'] ?? $product['stock']),
                    'variants' => trim($_POST['variants'] ?? $product['variants'] ?? '')
                ]
            );
            
            // Mettre à jour l'image si modifiée
            if ($imagePath !== $product['image_url']) {
                try {
                    $pdo = \App\Config\Database::getConnection();
                    $stmt = $pdo->prepare("UPDATE products SET image_url = ? WHERE id = ?");
                    $stmt->execute([$imagePath, $productId]);
                } catch (\Exception $e) {
                    // Ignorer les erreurs de mise à jour d'image
                }
            }
            
            header('Location: /admin/products?success=updated');
            exit;
        }
        
        $this->adminView('admin/edit_product', ['product' => $product]);
    }

    public function deleteOrder($id = null)
    {
        if ($id === null) {
            $id = (int)($_GET['params'][0] ?? 0);
        } else {
            $id = (int)$id;
        }
        
        if ($id > 0) {
            (new Order())->delete($id);
        }
        header('Location: /admin/orders');
        exit;
    }

    /**
     * Manage user roles (super_admin only)
     */
    public function manageRoles()
    {
        \App\Middleware\AdminMiddleware::checkSuperAdmin();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            \App\Middleware\CsrfMiddleware::checkPost();

            $userId = (int)($_POST['user_id'] ?? 0);
            $newRole = trim($_POST['role'] ?? '');

            if ($userId <= 0 || !in_array($newRole, ['user', 'moderator', 'admin', 'super_admin'])) {
                header('Location: /admin/roles?error=invalid');
                exit;
            }

            // Cannot change own role
            if ($userId === ($_SESSION['user']['id'] ?? 0)) {
                header('Location: /admin/roles?error=self');
                exit;
            }

            $userModel = new User();
            $userModel->run(
                "UPDATE users SET role = ? WHERE id = ?",
                [$newRole, $userId]
            );

            header('Location: /admin/roles?success=updated');
            exit;
        }

        $users = (new User())->getAll();
        $this->adminView('admin/manage-roles', compact('users'));
    }
}
