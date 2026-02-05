<?php
require_once dirname(__DIR__) . '/App/Config/Database.php';

$userId = $argv[1] ?? null;

if (!$userId) {
    echo "❌ Usage: php promote_to_super_admin.php <USER_ID>\n";
    exit(1);
}

$db = \App\Config\Database::getConnection();

// Get user info
$stmt = $db->prepare("SELECT id, name, email, role FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "❌ Utilisateur avec ID $userId non trouvé\n";
    exit(1);
}

// Update role to super_admin
$updateStmt = $db->prepare("UPDATE users SET role = 'super_admin' WHERE id = ?");
$updateStmt->execute([$userId]);

echo "✅ Utilisateur promu avec succès!\n";
echo "- ID: {$user['id']}\n";
echo "- Nom: {$user['name']}\n";
echo "- Email: {$user['email']}\n";
echo "- Ancien rôle: {$user['role']}\n";
echo "- Nouveau rôle: super_admin\n";
?>
