<?php
namespace App\Core;

require_once __DIR__ . '/Router.php';

class App
{
    public function run()
    {
        $router = new Router();
        $router->dispatch();
    }
}
