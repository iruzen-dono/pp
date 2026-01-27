<?php
namespace App\Core;

class Controller
{
    protected function view(string $view, array $data = [])
    {
        extract($data, EXTR_SKIP);

        $header = __DIR__ . '/../Views/Layouts/header.php';
        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        $footer = __DIR__ . '/../Views/Layouts/footer.php';

        if (!file_exists($viewFile)) {
            die("Vue introuvable : $viewFile");
        }

        require_once $header;
        require_once $viewFile;
        require_once $footer;
    }

    protected function adminView(string $view, array $data = [])
    {
        extract($data, EXTR_SKIP);

        $viewFile = __DIR__ . '/../Views/' . $view . '.php';
        $layout = __DIR__ . '/../Views/Admin/layout.php';

        if (!file_exists($viewFile) || !file_exists($layout)) {
            die("Vue admin introuvable");
        }

        ob_start();
        require $viewFile;
        $GLOBALS['admin_content'] = ob_get_clean();

        require $layout;
    }
}
