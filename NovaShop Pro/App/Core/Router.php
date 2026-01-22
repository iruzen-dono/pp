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
            'order' => 'Order',
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
        if ($urlPart === 'order') $defaultMethod = 'show';
        
        // Si url[1] est numérique, c'est un ID (pas une méthode)
        $methodName = $defaultMethod;
        if (!empty($url[1])) {
            if (!is_numeric($url[1])) {
                $methodName = $url[1];
                $_GET['params'] = array_slice($url, 2);
            } else {
                // C'est un ID, le passer comme premier param
                $_GET['params'] = array_slice($url, 1);
            }
        } else {
            $_GET['params'] = [];
        }

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
