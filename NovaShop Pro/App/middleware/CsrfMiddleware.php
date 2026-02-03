<?php
namespace App\Middleware;

class CsrfMiddleware
{
    public static function generateToken(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function verifyToken(?string $token): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return !empty($token) && hash_equals($_SESSION['csrf_token'] ?? '', $token);
    }

    public static function checkPost()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['_csrf'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!self::verifyToken($token)) {
                http_response_code(400);
                die('Invalid CSRF token');
            }
        }
    }
}
