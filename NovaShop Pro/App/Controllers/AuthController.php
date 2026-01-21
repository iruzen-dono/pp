<?php
namespace App\Controllers;

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../core/Controller.php';

use App\Core\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

            $user = new User();
            $user->create($name, $email, $password);

            header("Location: /login");
            exit;
        }

        $this->view('auth/register');
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if ($user && password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['user'] = $user;
                header("Location: /");
                exit;
            }

            $error = "Email ou mot de passe incorrect.";
            $this->view('auth/login', compact('error'));
            return;
        }

        $this->view('auth/login');
    }

    public function logout()
    {
        session_start();
        session_destroy();
        header("Location: /");
        exit;
    }
}
