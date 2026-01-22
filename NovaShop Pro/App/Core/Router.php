<?php
namespace App\Core;

require_once __DIR__ . '/Controller.php';

class Router
{
    public function dispatch()
    {
        $url = $_GET['url'] ?? 'home';

        $url = explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));

        // Normaliser les noms (products -> Product, login -> Auth, etc.)
        $urlPart = $url[0];
        $controllerMap = [
            'products' => 'Product',
            'login' => 'Auth',
            'register' => 'Auth',
            'cart' => 'Cart',
            'order' => 'Order',
            'admin' => 'Admin',
            'home' => 'Home',
        ];

        $baseName = $controllerMap[$urlPart] ?? ucfirst($urlPart);
        $controllerName = $baseName . 'Controller';
        $methodName = $url[1] ?? ($urlPart === 'login' ? 'login' : ($urlPart === 'register' ? 'register' : 'index'));

        $controllerFile = __DIR__ . '/../Controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            die("❌ Controller $controllerName introuvable (URL: $urlPart)");
        }

        require_once $controllerFile;

        $controllerClass = "App\\Controllers\\$controllerName";
        $controller = new $controllerClass();

        if (!method_exists($controller, $methodName)) {
            die("❌ Méthode $methodName introuvable dans $controllerName");
        }

        call_user_func_array([$controller, $methodName], []);
    }
}
