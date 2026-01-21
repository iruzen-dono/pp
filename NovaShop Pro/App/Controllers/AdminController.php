<?php
namespace App\Controllers;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../middleware/AdminMiddleware.php';

use App\Core\Controller;
use App\Middleware\AdminMiddleware;

class AdminController extends Controller
{
    public function __construct()
    {
        AdminMiddleware::check();
    }

    public function dashboard()
    {
        $this->view('admin/dashboard');
    }

    public function users()
    {
        $this->view('admin/users');
    }

    public function products()
    {
        $this->view('admin/products');
    }

    public function orders()
    {
        $this->view('admin/orders');
    }
}
