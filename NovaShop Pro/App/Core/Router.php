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
            'login'    => ['Auth', 'login'],
            'register' => ['Auth', 'register'],
            'logout'   => ['Auth', 'logout'],
            'products' => ['Product', 'index'],
            'cart'     => ['Cart', 'index'],
            'home'     => ['Home', 'index']
        ];

        if (isset($controllerMap[$parts[0]])) {
            $controllerName = $controllerMap[$parts[0]][0] . 'Controller';
            $methodName = $controllerMap[$parts[0]][1];
            $params = array_slice($parts, 1);
        } else {
            $controllerName = ucfirst($parts[0]) . 'Controller';
            $methodName = $parts[1] ?? 'index';
            $params = array_slice($parts, 2);
        }

        $controllerFile = __DIR__ . '/../Controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            $this->abort(404, "Controller $controllerName introuvable");
            return;
        }

        require_once $controllerFile;
        $controllerClass = "App\\Controllers\\$controllerName";

        if (!class_exists($controllerClass)) {
            $this->abort(404, "Classe $controllerClass introuvable");
            return;
        }

        $controller = new $controllerClass();

        if (!method_exists($controller, $methodName) || is_numeric($methodName)) {
            if (method_exists($controller, 'index')) {
                array_unshift($params, $methodName);
                $methodName = 'index';
            } else {
                $this->abort(404, "Méthode $methodName introuvable");
                return;
            }
        }

        call_user_func_array([$controller, $methodName], $params);
    }

    private function abort($code, $message)
    {
        http_response_code($code);
        echo "<h1>Erreur $code</h1><p>$message</p>";
    }
}
