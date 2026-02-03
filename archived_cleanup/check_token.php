<?php
require 'App/Config/Database.php';
use App\Config\Database;

$token = '43b67c36d00721b369b22dcc5301c2316438317b23c788f7b66af690238863cc';

$pdo = Database::getConnection();

echo "🔍 Recherche du token: $token\n\n";

$stmt = $pdo->prepare("SELECT * FROM email_verification_tokens WHERE token = ?");
$stmt->execute([$token]);
$tokenData = $stmt->fetch();

if ($tokenData) {
    echo "✅ Token TROUVÉ!\n";
    echo "User ID: {$tokenData['user_id']}\n";
    echo "Expires at: {$tokenData['expires_at']}\n";
    echo "Created at: {$tokenData['created_at']}\n";
    
    // Vérifier si expiré
    $now = new DateTime();
    $expiry = new DateTime($tokenData['expires_at']);
    
    if ($expiry > $now) {
        echo "Status: ✅ Valide\n";
    } else {
        echo "Status: ❌ EXPIRÉ\n";
    }
} else {
    echo "❌ Token NOT FOUND!\n";
    echo "\nTokens disponibles:\n";
    $stmt = $pdo->query("SELECT * FROM email_verification_tokens");
    foreach ($stmt->fetchAll() as $t) {
        echo "  - {$t['token']} (user_id: {$t['user_id']}, expires: {$t['expires_at']})\n";
    }
}
?>
