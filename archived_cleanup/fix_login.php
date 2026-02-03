<?php
require 'App/Config/Database.php';
use App\Config\Database;

echo "╔══════════════════════════════════════════════╗\n";
echo "║   CORRECTION MANUELLE DU COMPTE              ║\n";
echo "╚══════════════════════════════════════════════╝\n\n";

$pdo = Database::getConnection();

// Récupérer l'utilisateur Zhou Jules
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = 'juleszhou00@gmail.com'");
$stmt->execute();
$user = $stmt->fetch();

if (!$user) {
    echo "❌ Utilisateur non trouvé\n";
    exit;
}

echo "👤 Utilisateur trouvé: {$user['name']}\n";
echo "   Email: {$user['email']}\n\n";

// Marquer l'email comme vérifié
echo "📝 Mise à jour du compte...\n";
$stmt = $pdo->prepare("
    UPDATE users 
    SET email_verified_at = NOW(), is_active = TRUE 
    WHERE id = ?
");
$stmt->execute([$user['id']]);

// Supprimer les anciens tokens
$stmt = $pdo->prepare("DELETE FROM email_verification_tokens WHERE user_id = ?");
$stmt->execute([$user['id']]);

echo "✅ Compte activé!\n\n";

// Vérifier le résultat
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user['id']]);
$updated = $stmt->fetch();

echo "🔍 Vérification:\n";
echo "   Email vérifié: " . (!empty($updated['email_verified_at']) ? "✅ OUI" : "❌ NON") . "\n";
echo "   Actif: " . ($updated['is_active'] ? "✅ OUI" : "❌ NON") . "\n";

echo "\n✅ Tu peux maintenant te connecter avec:\n";
echo "   Email: juleszhou00@gmail.com\n";
echo "   Password: (celui que tu as entré lors de l'inscription)\n";
?>
