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
            'logout' => 'Auth',
            'cart' => 'Cart',
            'orders' => 'Order',
            'admin' => 'Admin',
            'home' => 'Home',
        ];

        $baseName = $controllerMap[$urlPart] ?? ucfirst($urlPart);
        $controllerName = $baseName . 'Controller';
        
        // Déterminer la méthode par défaut selon l'URL
        $defaultMethod = 'index';
        if ($urlPart === 'login') $defaultMethod = 'login';
        if ($urlPart === 'register') $defaultMethod = 'register';
        if ($urlPart === 'logout') $defaultMethod = 'logout';
        
        $methodName = $url[1] ?? $defaultMethod;

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
