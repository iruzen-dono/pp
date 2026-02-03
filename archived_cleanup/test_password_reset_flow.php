<?php
require_once __DIR__ . '/App/Models/User.php';
require_once __DIR__ . '/App/Models/PasswordReset.php';

use App\Models\User;
use App\Models\PasswordReset;

// Simple CLI test: php test_password_reset_flow.php email@example.com
$email = $argv[1] ?? null;
if (!$email) {
    echo "Usage: php test_password_reset_flow.php user@example.com\n";
    exit(1);
}

$userModel = new User();
$user = $userModel->findByEmail($email);

if (!$user) {
    echo "Utilisateur introuvable pour: $email\n";
    exit(1);
}

$pr = new PasswordReset();
$pr->deleteByUserId((int)$user['id']);
$token = $pr->create((int)$user['id']);

echo "Token généré: $token\n";

$found = $pr->getByToken($token);
if ($found) {
    echo "✅ Token présent en base pour user_id: " . $found['user_id'] . " expires: " . $found['expires_at'] . "\n";
} else {
    echo "❌ Token introuvable en base.\n";
}
