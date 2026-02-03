<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';

class UserController extends Controller
{
    /**
     * Afficher le profil de l'utilisateur
     */
    public function profile()
    {
        // Vérifier que l'utilisateur est connecté (supporte ancien et nouveau format de session)
        $userId = $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($userId);

        if (!$user) {
            $error = "Utilisateur non trouvé";
            return $this->view('user/profile', compact('error'));
        }

        return $this->view('user/profile', compact('user'));
    }

    /**
     * Afficher les paramètres
     */
    public function settings()
    {
        // Vérifier que l'utilisateur est connecté (supporte ancien et nouveau format de session)
        $userId = $_SESSION['user']['id'] ?? $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header('Location: /login');
            exit;
        }

        $userModel = new User();
        $user = $userModel->findById($userId);

        if (!$user) {
            $error = "Utilisateur non trouvé";
            return $this->view('user/settings', compact('error'));
        }

        $message = null;
        $error = null;

        // Traiter les modifications
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            \App\Middleware\CsrfMiddleware::checkPost();

            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $currentPassword = $_POST['current_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['confirm_password'] ?? '';

            // Validation
            if ($name === '' || $email === '') {
                $error = "Le nom et l'email sont obligatoires";
            } elseif ($email !== $user['email'] && $userModel->findByEmail($email)) {
                $error = "Cet email est déjà utilisé";
            } elseif ($newPassword !== '' && strlen($newPassword) < 6) {
                $error = "Le nouveau mot de passe doit contenir au moins 6 caractères";
            } elseif ($newPassword !== '' && $newPassword !== $confirmPassword) {
                $error = "Les mots de passe ne correspondent pas";
            } elseif ($newPassword !== '' && !password_verify($currentPassword, $user['password'])) {
                $error = "Le mot de passe actuel est incorrect";
            } else {
                // Mise à jour des données
                try {
                    if ($name !== $user['name'] || $email !== $user['email']) {
                        $userModel->update($userId, $name, $email);
                    }

                    if ($newPassword !== '') {
                        $userModel->updatePassword($userId, password_hash($newPassword, PASSWORD_BCRYPT));
                    }

                    // Recharger les données
                    $user = $userModel->findById($userId);
                    $message = "✅ Paramètres mis à jour avec succès!";
                } catch (\Exception $e) {
                    $error = "Erreur lors de la mise à jour: " . $e->getMessage();
                }
            }
        }

        return $this->view('user/settings', compact('user', 'message', 'error'));
    }
}
