<?php
require 'App/Config/Database.php';
use App\Config\Database;

echo "╔════════════════════════════════════════════════╗\n";
echo "║   DIAGNOSTIC - PROBLÈME DE CONNEXION           ║\n";
echo "╚════════════════════════════════════════════════╝\n\n";

try {
    $pdo = Database::getConnection();
    
    echo "📧 État des utilisateurs en base de données:\n";
    echo "────────────────────────────────────────────\n";
    
    $stmt = $pdo->query("
        SELECT 
            id,
            name,
            email,
            is_active,
            email_verified_at,
            created_at
        FROM users
        ORDER BY created_at DESC
    ");
    
    $users = $stmt->fetchAll();
    
    if (empty($users)) {
        echo "❌ Aucun utilisateur trouvé!\n";
    } else {
        foreach ($users as $user) {
            echo "\n👤 Utilisateur: {$user['name']}\n";
            echo "   Email: {$user['email']}\n";
            echo "   ID: {$user['id']}\n";
            echo "   Actif: " . ($user['is_active'] ? "✅ OUI" : "❌ NON") . "\n";
            echo "   Email Vérifié: " . (!empty($user['email_verified_at']) ? "✅ OUI ({$user['email_verified_at']})" : "❌ NON") . "\n";
            echo "   Créé: {$user['created_at']}\n";
        }
    }
    
    echo "\n\n📝 Fichier de log:\n";
    echo "────────────────\n";
    
    $log_file = 'logs/email_verification.log';
    if (file_exists($log_file)) {
        $content = file_get_contents($log_file);
        echo $content;
    } else {
        echo "❌ Fichier de log non trouvé\n";
    }
    
    echo "\n\n🔍 Vérification du formulaire de connexion:\n";
    echo "──────────────────────────────────────────\n";
    echo "Si tu vois le problème ci-dessus, dis-moi:\n";
    echo "1. Le email est-il marqué comme vérifié? (✅ ou ❌)\n";
    echo "2. Le compte est-il actif? (✅ ou ❌)\n";
    echo "3. Quel message d'erreur apparaît lors de la connexion?\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}
?>
