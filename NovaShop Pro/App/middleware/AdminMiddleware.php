<?php
namespace App\Middleware;

class AdminMiddleware
{
    public static function check()
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            die("❌ Accès administrateur requis");
        }
    }
}
