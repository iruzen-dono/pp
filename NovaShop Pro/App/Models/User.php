<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function getAll(string $sortBy = 'created_at', string $sortOrder = 'DESC'): array
    {
        // Whitelist allowed sort columns to prevent SQL injection
        $allowedColumns = ['id', 'name', 'email', 'role', 'is_active', 'created_at'];
        $sortBy = in_array($sortBy, $allowedColumns) ? $sortBy : 'created_at';
        $sortOrder = in_array(strtoupper($sortOrder), ['ASC', 'DESC']) ? strtoupper($sortOrder) : 'DESC';
        
        return $this->run(
            "SELECT * FROM users ORDER BY {$sortBy} {$sortOrder}"
        );
    }

    public function findByEmail(string $email): ?array
    {
        return $this->run(
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$email],
            true
        );
    }

    public function create(string $name, string $email, string $password): int
    {
        $this->run(
            "INSERT INTO users (name, email, password, is_active, email_verified_at) 
             VALUES (?, ?, ?, 1, NOW())",
            [$name, $email, $password]
        );
        
        // Retourner l'ID du nouvel utilisateur
        return (int) $this->db->lastInsertId();
    }

    /**
     * Marquer l'email comme vérifié
     */
    public function verifyEmail(int $userId): int
    {
        return $this->run(
            "UPDATE users SET email_verified_at = NOW(), is_active = TRUE WHERE id = ?",
            [$userId]
        );
    }

    /**
     * Changer le rôle d'un utilisateur
     */
    public function changeRole(int $userId, string $newRole): int
    {
        return $this->run(
            "UPDATE users SET role = ? WHERE id = ?",
            [$newRole, $userId]
        );
    }

    /**
     * Vérifier si l'email est confirmé
     */
    public function isEmailVerified(int $userId): bool
    {
        $user = $this->run(
            "SELECT email_verified_at FROM users WHERE id = ? LIMIT 1",
            [$userId],
            true
        );
        
        return $user && !empty($user['email_verified_at']);
    }

    /**
     * Soft delete: Deactivate a user account (keeps history)
     */
    public function deactivate(int $id): int
    {
        return $this->run(
            "UPDATE users SET is_active = FALSE, deactivated_at = NOW() WHERE id = ?",
            [$id]
        );
    }

    /**
     * Reactivate a deactivated user
     */
    public function reactivate(int $id): int
    {
        return $this->run(
            "UPDATE users SET is_active = TRUE, deactivated_at = NULL WHERE id = ?",
            [$id]
        );
    }

    /**
     * Hard delete: Only for permanent removal (use with extreme caution)
     * This is preserved but should only be called by super_admin
     */
    public function delete(int $id): int
    {
        return $this->run(
            "DELETE FROM users WHERE id = ?",
            [$id]
        );
    }

    /**
     * Delete a user and clean up related data across the app.
     * Returns true on success, false on error.
     */
    public function deleteWithCleanup(int $userId): bool
    {
        try {
            $this->db->beginTransaction();

            // Ensure models are available
            require_once __DIR__ . '/EmailVerificationToken.php';
            require_once __DIR__ . '/PasswordReset.php';
            require_once __DIR__ . '/Order.php';
            require_once __DIR__ . '/OrderItem.php';

            $evModel = new EmailVerificationToken();
            $prModel = new PasswordReset();
            $orderModel = new Order();
            $orderItemModel = new OrderItem();

            // 1) Remove email verification tokens
            try { $evModel->deleteByUserId($userId); } catch (\Exception $e) { }

            // 2) Remove password reset tokens (DB or fallback)
            try { $prModel->deleteByUserId($userId); } catch (\Exception $e) { }

            // 3) Remove orders and order items for this user
            try {
                $orders = $orderModel->getByUserId($userId);
                foreach ($orders as $o) {
                    $orderItemModel->deleteByOrderId((int)$o['id']);
                    $orderModel->delete((int)$o['id']);
                }
            } catch (\Exception $e) { }

            // 4) Finally delete the user record
            $this->run("DELETE FROM users WHERE id = ?", [$userId]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            try { $this->db->rollBack(); } catch (\Exception $_) { }
            @file_put_contents(__DIR__ . '/../../logs/user_delete.log', "[".date('Y-m-d H:i:s')."] Error deleting user {$userId}: " . $e->getMessage() . "\n", FILE_APPEND);
            return false;
        }
    }

    /**
     * Trouver un utilisateur par ID
     */
    public function findById(int $id): ?array
    {
        return $this->run(
            "SELECT * FROM users WHERE id = ? LIMIT 1",
            [$id],
            true
        );
    }

    /**
     * Mettre à jour le nom et l'email
     */
    public function update(int $id, string $name, string $email): int
    {
        return $this->run(
            "UPDATE users SET name = ?, email = ? WHERE id = ?",
            [$name, $email, $id]
        );
    }

    /**
     * Mettre à jour le mot de passe
     */
    public function updatePassword(int $id, string $hashedPassword): int
    {
        return $this->run(
            "UPDATE users SET password = ? WHERE id = ?",
            [$hashedPassword, $id]
        );
    }
}
