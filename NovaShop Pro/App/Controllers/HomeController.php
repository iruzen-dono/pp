<?php
namespace App\Controllers;

require_once __DIR__ . '/../Core/Controller.php'; // 👈 IMPORTANT

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $this->view('home/index');
    }
}
