<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $productModel = new Product();
        $products = $productModel->getAll() ?? [];

        $this->view('home/index', [
            'products' => $products
        ]);
    }
}
