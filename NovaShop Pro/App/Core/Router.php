<?php
namespace App\Core;

class Router
{
    public function dispatch()
    {
        $url = $_GET['url'] ?? 'home';
        $url = trim($url, '/');
        $parts = explode('/', filter_var($url, FILTER_SANITIZE_URL));

        $controllerMap = [
            'login'           => ['Auth', 'login'],
            'register'        => ['Auth', 'register'],
            'logout'          => ['Auth', 'logout'],
            'verify-email'    => ['Auth', 'verifyEmail'],
            'forgot'          => ['Auth', 'forgot'],
            'reset-password'  => ['Auth', 'resetPassword'],
            'products'        => ['Product', 'index'],
            'cart'            => ['Cart', 'index'],
            'home'            => ['Home', 'index'],
            'orders'          => ['Order', 'index'],
            'profile'         => ['User', 'profile'],
            'settings'        => ['User', 'settings']
        ];

        if (isset($controllerMap[$parts[0]])) {
            $controllerName = $controllerMap[$parts[0]][0] . 'Controller';
            $methodName = $controllerMap[$parts[0]][1];
            $params = array_slice($parts, 1);
            
            // Special handling for products: if there's an ID parameter, use show method
            if ($parts[0] === 'products' && isset($parts[1]) && is_numeric($parts[1])) {
                $methodName = 'show';
                $params = array_slice($parts, 1);
            }
            
            // Special handling for cart: if there's a method (add, remove), use it
            if ($parts[0] === 'cart' && isset($parts[1]) && !is_numeric($parts[1])) {
                $methodName = $parts[1];
                $params = array_slice($parts, 2);
            }
            
            // Special handling for orders: if there's a method (create, show), use it
            if ($parts[0] === 'orders' && isset($parts[1]) && !is_numeric($parts[1])) {
                $methodName = $parts[1];
                $params = array_slice($parts, 2);
            }
        } else {
            $controllerName = ucfirst($parts[0]) . 'Controller';
            $methodName = $parts[1] ?? 'index';
            $params = array_slice($parts, 2);
            
            // Special handling for admin routes
            if ($parts[0] === 'admin' && isset($parts[1])) {
                // For nested routes like /admin/products/edit/5
                if ($parts[1] === 'products' && isset($parts[2]) && $parts[2] === 'edit' && isset($parts[3])) {
                    $methodName = 'editProduct';
                    $params = [$parts[3]];
                } else {
                    // For routes like /admin/deleteUser/5, /admin/deleteProduct/5, etc.
                    $methodName = $parts[1];
                    $params = isset($parts[2]) ? [$parts[2]] : [];
                }
            }
        }

        $controllerFile = __DIR__ . '/../Controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            $this->abort(404, "Controller introuvable");
            return;
        }

        require_once $controllerFile;
        $controllerClass = "App\\Controllers\\$controllerName";
        $controller = new $controllerClass();

        if (!method_exists($controller, $methodName)) {
            $this->abort(404, "Méthode introuvable");
            return;
        }

        call_user_func_array([$controller, $methodName], $params);
    }

    private function abort($code, $message)
    {
        http_response_code($code);
        echo "<h1>Erreur $code</h1><p>$message</p>";
    }
}
