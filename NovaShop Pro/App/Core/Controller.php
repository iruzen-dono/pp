<?php
namespace App\Core;

class Controller
{
    protected function view($view, $data = [])
    {
        extract($data);
        require_once __DIR__ . '/../Views/Layouts/header.php';
        require_once __DIR__ . '/../Views/' . $view . '.php';
        require_once __DIR__ . '/../Views/Layouts/footer.php';
    }

    protected function adminView($view, $data = [])
    {
        extract($data);
        ob_start();
        require __DIR__ . '/../Views/' . $view . '.php';
        $GLOBALS['admin_content'] = ob_get_clean();
        require __DIR__ . '/../Views/Admin/layout.php';
    }
}
