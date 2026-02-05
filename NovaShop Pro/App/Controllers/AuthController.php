<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;
use App\Models\PasswordReset;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Models/PasswordReset.php';
require_once __DIR__ . '/../Middleware/CsrfMiddleware.php';

class AuthController extends Controller
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            \App\Middleware\CsrfMiddleware::checkPost();

            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // 1. Validation minimale
            if ($name === '' || $email === '' || $password === '') {
                $error = "Tous les champs sont obligatoires.";
                return $this->view('auth/register', compact('error'));
            }

            if (strlen($password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères.";
                return $this->view('auth/register', compact('error'));
            }

            $userModel = new User();

            try {
                // 2. Vérifier si l'email existe déjà
                if ($userModel->findByEmail($email)) {
                    $error = "Cet email est déjà utilisé.";
                    return $this->view('auth/register', compact('error'));
                }

                // 3. Hash du mot de passe
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

                // 4. Création utilisateur (non actif par défaut)
                $userId = $userModel->create($name, $email, $hashedPassword);

                if ($userId <= 0) {
                    $error = "Impossible de créer le compte. Réessayez plus tard.";
                    return $this->view('auth/register', compact('error'));
                }

                // 5. Compte créé et vérifié automatiquement
                $message = "✅ Compte créé avec succès! Vous pouvez maintenant vous connecter.";
                return $this->view('auth/register-success', compact('message', 'email', 'name'));

            } catch (\Exception $e) {
                $error = "Erreur lors de la création du compte: " . ($e->getMessage() ?: 'erreur serveur');
                return $this->view('auth/register', compact('error'));
            }
        }

        $this->view('auth/register');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            \App\Middleware\CsrfMiddleware::checkPost();

            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = "Veuillez remplir tous les champs.";
                return $this->view('auth/login', compact('error'));
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            // Vérifier que l'utilisateur existe
            if (!$user) {
                $error = "Email ou mot de passe incorrect.";
                return $this->view('auth/login', compact('error'));
            }

            // Vérifier le mot de passe
            if (!password_verify($password, $user['password'])) {
                $error = "Email ou mot de passe incorrect.";
                return $this->view('auth/login', compact('error'));
            }

            // Vérifier que l'utilisateur est actif
            if (!($user['is_active'] ?? true)) {
                $error = "Ce compte a été désactivé. Contactez un administrateur.";
                return $this->view('auth/login', compact('error'));
            }

            // Sécurité session
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role'] ?? 'user'
            ];

            header("Location: /");
            exit;
        }

        $this->view('auth/login');
    }

    /**
     * Afficher le formulaire "mot de passe oublié" ou traiter la demande
     */
    public function forgot()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            \App\Middleware\CsrfMiddleware::checkPost();

            $email = trim($_POST['email'] ?? '');

            if ($email === '') {
                $error = "Veuillez fournir une adresse email.";
                return $this->view('auth/forgot', compact('error'));
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            // Toujours afficher le même message pour éviter la révélation d'existence
            $message = "Si un compte existe pour cette adresse, un email contenant un lien de réinitialisation a été envoyé.";

            if (!$user) {
                return $this->view('auth/forgot-pending', compact('message'));
            }

            $passwordReset = new PasswordReset();
            // Supprimer les anciens tokens pour cet utilisateur
            $passwordReset->deleteByUserId((int)$user['id']);

            $token = $passwordReset->create((int)$user['id']);

            EmailService::sendPasswordResetEmail($email, $token, $user['name'] ?? $user['email']);

            return $this->view('auth/forgot-pending', compact('message'));
        }

        $this->view('auth/forgot');
    }

    /**
     * Gérer l'affichage du form de réinitialisation et le POST pour définir le nouveau mot de passe
     */
    public function resetPassword()
    {
        $token = $_GET['token'] ?? ($_POST['token'] ?? null);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            \App\Middleware\CsrfMiddleware::checkPost();

            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if ($password === '' || $passwordConfirm === '') {
                $error = "Tous les champs sont obligatoires.";
                return $this->view('auth/reset', compact('error', 'token'));
            }

            if ($password !== $passwordConfirm) {
                $error = "Les mots de passe ne correspondent pas.";
                return $this->view('auth/reset', compact('error', 'token'));
            }

            if (strlen($password) < 6) {
                $error = "Le mot de passe doit contenir au moins 6 caractères.";
                return $this->view('auth/reset', compact('error', 'token'));
            }

            if (!$token) {
                $error = "Token manquant.";
                return $this->view('auth/reset-error', compact('error'));
            }

            $passwordReset = new PasswordReset();
            $tokenData = $passwordReset->getByToken($token);

            if (!$tokenData) {
                $error = "Le lien de réinitialisation est invalide ou a expiré.";
                return $this->view('auth/reset-error', compact('error'));
            }

            $userId = (int)$tokenData['user_id'];
            $userModel = new User();

            $hashed = password_hash($password, PASSWORD_BCRYPT);
            $rowsAffected = $userModel->updatePassword($userId, $hashed);

            // Log password update for debugging
            $logFile = __DIR__ . '/../../logs/password_reset_update.log';
            @mkdir(dirname($logFile), 0755, true);
            $logMsg = "[" . date('Y-m-d H:i:s') . "] User ID: $userId | Rows affected: $rowsAffected | Hash: " . substr($hashed, 0, 20) . "...\n";
            @file_put_contents($logFile, $logMsg, FILE_APPEND);

            // Supprimer le token utilisé
            $passwordReset->deleteByUserId($userId);

            $message = "✅ Votre mot de passe a bien été réinitialisé. Vous pouvez maintenant vous connecter.";
            return $this->view('auth/reset-success', compact('message'));
        }

        if (!$token) {
            $error = "Token manquant.";
            return $this->view('auth/reset-error', compact('error'));
        }

        // Vérifier la validité du token
        $passwordReset = new PasswordReset();
        $tokenData = $passwordReset->getByToken($token);

        if (!$tokenData) {
            $error = "Le lien de réinitialisation est invalide ou a expiré.";
            return $this->view('auth/reset-error', compact('error'));
        }

        // Afficher le formulaire de réinitialisation
        return $this->view('auth/reset', compact('token'));
    }

    public function logout()
    {
        // Nettoyage propre de la session
        $_SESSION = [];
        session_destroy();

        header("Location: /");
        exit;
    }
}
?>
