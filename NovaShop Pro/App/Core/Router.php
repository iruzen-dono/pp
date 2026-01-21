<?php
namespace App\Core;

require_once __DIR__ . '/Controller.php'; // 👈 ajoute ça

class Router
{
    public function dispatch()
    {
        $url = $_GET['url'] ?? 'home/index';

        $url = explode('/', filter_var(rtrim($url, '/'), FILTER_SANITIZE_URL));

        $controllerName = ucfirst($url[0]) . 'Controller';
        $methodName = $url[1] ?? 'index';

        $controllerFile = __DIR__ . '/../controllers/' . $controllerName . '.php';

        if (!file_exists($controllerFile)) {
            die("❌ Controller $controllerName introuvable");
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
