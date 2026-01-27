<?php
namespace App\Core;

require_once __DIR__ . '/Router.php';

class App
{
    public function run()
    {
        try {
            $router = new Router();
            $router->dispatch();
        } catch (\Throwable $e) {

            // En mode dev : afficher l'erreur
            http_response_code(500);
            echo "<h1>Erreur interne</h1>";
            echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";

        }
    }
}
