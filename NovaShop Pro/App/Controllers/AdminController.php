<?php
namespace App\Controllers;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/Product.php';
require_once __DIR__ . '/../Models/Order.php';

use App\Core\Controller;
use App\Middleware\AdminMiddleware;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

class AdminController extends Controller
{
    public function __construct()
    {
        AdminMiddleware::check();
    }

    public function dashboard()
    {
        // Récupérer les statistiques
        $userModel = new User();
        $productModel = new Product();
        $orderModel = new Order();
        
        $stats = [
            'users_count' => count($userModel->getAll()),
            'products_count' => count($productModel->getAll()),
            'orders_count' => count($orderModel->getAll())
        ];
        
        $this->adminView('admin/dashboard', $stats);
    }

    public function users()
    {
        $userModel = new User();
        $users = $userModel->getAll();
        $this->adminView('admin/users', ['users' => $users]);
    }

    public function products()
    {
        // Gestion des actions POST (création, édition, suppression)
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'] ?? '';
            
            if ($action === 'create') {
                $imagePath = '';
                
                // Gestion de l'upload d'image
                if (!empty($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $file = $_FILES['image'];
                    $uploadDir = __DIR__ . '/../../Public/Assets/Images/products/';
                    
                    // Créer le dossier s'il n'existe pas
                    if (!is_dir($uploadDir)) {
                        mkdir($uploadDir, 0755, true);
                    }
                    
                    // Vérifier le type MIME
                    $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
                    $finfo = finfo_open(FILEINFO_MIME_TYPE);
                    $mimeType = finfo_file($finfo, $file['tmp_name']);
                    finfo_close($finfo);
                    
                    if (!in_array($mimeType, $allowedMimes)) {
                        // Type non autorisé
                        header('Location: /admin/products?error=invalid_image_type');
                        exit;
                    }
                    
                    // Vérifier la taille (5MB max)
                    if ($file['size'] > 5 * 1024 * 1024) {
                        header('Location: /admin/products?error=image_too_large');
                        exit;
                    }
                    
                    // Générer un nom de fichier unique
                    $fileName = 'product_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                    $filePath = $uploadDir . $fileName;
                    
                    // Déplacer le fichier
                    if (move_uploaded_file($file['tmp_name'], $filePath)) {
                        // Utiliser le chemin relatif pour la base de données
                        $imagePath = '/Assets/Images/products/' . $fileName;
                    }
                }
                
                $productModel = new Product();
                $productModel->create([
                    'name' => $_POST['name'] ?? '',
                    'description' => $_POST['description'] ?? '',
                    'image_url' => $imagePath,
                    'price' => (float)($_POST['price'] ?? 0),
                    'category_id' => (int)($_POST['category_id'] ?? 1),
                    'stock' => (int)($_POST['stock'] ?? 0)
                ]);
                // Rediriger après création
                header('Location: /admin/products?success=1');
                exit;
            }
        }
        
        // Afficher la liste des produits
        $productModel = new Product();
        $products = $productModel->getAll();
        $this->adminView('admin/products', ['products' => $products]);
    }

    public function orders()
    {
        $orderModel = new Order();
        $orders = $orderModel->getAll();
        $this->adminView('admin/orders', ['orders' => $orders]);
    }

    public function deleteUser()
    {
        $userId = $_GET['params'][0] ?? null;
        
        if (!$userId) {
            header('Location: /admin/users');
            exit;
        }
        
        // Éviter la suppression de l'admin actuel
        if ($userId == $_SESSION['user']['id']) {
            header('Location: /admin/users?error=cannot_delete_self');
            exit;
        }
        
        $userModel = new User();
        $userModel->delete($userId);
        
        header('Location: /admin/users?success=deleted');
        exit;
    }

    public function deleteProduct()
    {
        $productId = $_GET['params'][0] ?? null;
        
        if (!$productId) {
            header('Location: /admin/products');
            exit;
        }
        
        $productModel = new Product();
        $productModel->delete($productId);
        
        header('Location: /admin/products?success=deleted');
        exit;
    }

    public function deleteOrder()
    {
        $orderId = $_GET['params'][0] ?? null;
        
        if (!$orderId) {
            header('Location: /admin/orders');
            exit;
        }
        
        $orderModel = new Order();
        $orderModel->delete($orderId);
        
        header('Location: /admin/orders?success=deleted');
        exit;
    }
}
