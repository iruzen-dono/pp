<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

require_once __DIR__ . '/../Core/Controller.php';
require_once __DIR__ . '/../Models/User.php';

class AuthController extends Controller
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $name     = trim($_POST['name'] ?? '');
            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // 1. Validation minimale
            if ($name === '' || $email === '' || $password === '') {
                $error = "Tous les champs sont obligatoires.";
                return $this->view('auth/register', compact('error'));
            }

            $userModel = new User();

            // 2. Vérifier si l'email existe déjà
            if ($userModel->findByEmail($email)) {
                $error = "Cet email est déjà utilisé.";
                return $this->view('auth/register', compact('error'));
            }

            // 3. Hash du mot de passe
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // 4. Création utilisateur
            $userModel->create($name, $email, $hashedPassword);

            // 5. Redirection
            header("Location: /login");
            exit;
        }

        $this->view('auth/register');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $email    = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($email === '' || $password === '') {
                $error = "Veuillez remplir tous les champs.";
                return $this->view('auth/login', compact('error'));
            }

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {

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

            $error = "Email ou mot de passe incorrect.";
            return $this->view('auth/login', compact('error'));
        }

        $this->view('auth/login');
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
