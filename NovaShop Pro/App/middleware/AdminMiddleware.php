<?php
namespace App\Middleware;

class AdminMiddleware
{
    /**
     * Check if user is at least admin (admin or super_admin)
     */
    public static function check()
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(403);
            die("❌ Accès administrateur requis");
        }

        $role = $_SESSION['user']['role'] ?? 'user';
        $allowedRoles = ['admin', 'super_admin'];
        
        if (!in_array($role, $allowedRoles)) {
            http_response_code(403);
            die("❌ Accès administrateur requis (rôle: " . htmlspecialchars($role) . ")");
        }
    }

    /**
     * Check if user is super_admin
     */
    public static function checkSuperAdmin()
    {
        self::check(); // First check if admin
        
        $role = $_SESSION['user']['role'] ?? 'user';
        if ($role !== 'super_admin') {
            http_response_code(403);
            die("❌ Accès super administrateur requis");
        }
    }

    /**
     * Check specific role
     */
    public static function checkRole($requiredRole)
    {
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== $requiredRole) {
            http_response_code(403);
            die("❌ Rôle requis: " . htmlspecialchars($requiredRole));
        }
    }
}
