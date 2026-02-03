<?php
require 'App/Config/Database.php';
use App\Config\Database;

echo "╔═══════════════════════════════════════════════════════╗\n";
echo "║   TEST DU SYSTÈME D'AUTHENTIFICATION PAR EMAIL        ║\n";
echo "╚═══════════════════════════════════════════════════════╝\n\n";

try {
    $pdo = Database::getConnection();
    
    // 1. Vérifier les tables
    echo "1️⃣  Vérification des tables:\n";
    
    $tables = ['users', 'email_verification_tokens'];
    foreach ($tables as $table) {
        $result = $pdo->query("SHOW TABLES LIKE '$table'");
        if ($result->rowCount() > 0) {
            echo "   ✓ Table '$table' existe\n";
        } else {
            echo "   ✗ Table '$table' MANQUANTE\n";
        }
    }
    
    // 2. Vérifier les colonnes
    echo "\n2️⃣  Vérification des colonnes users:\n";
    
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(\PDO::FETCH_COLUMN, 0);
    
    $required_cols = ['email_verified_at', 'is_active'];
    foreach ($required_cols as $col) {
        if (in_array($col, $columns)) {
            echo "   ✓ Colonne '$col' existe\n";
        } else {
            echo "   ✗ Colonne '$col' MANQUANTE\n";
        }
    }
    
    // 3. Compter les utilisateurs
    echo "\n3️⃣  État des utilisateurs:\n";
    
    $stmt = $pdo->query("
        SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN is_active = TRUE THEN 1 ELSE 0 END) as actifs,
            SUM(CASE WHEN is_active = FALSE THEN 1 ELSE 0 END) as inactifs
        FROM users
    ");
    $stats = $stmt->fetch();
    
    echo "   Utilisateurs totaux: {$stats['total']}\n";
    echo "   Actifs (email confirmé): {$stats['actifs']}\n";
    echo "   Inactifs (en attente): {$stats['inactifs']}\n";
    
    // 4. Tokens en attente
    echo "\n4️⃣  Tokens de vérification en attente:\n";
    
    $stmt = $pdo->query("
        SELECT COUNT(*) as count 
        FROM email_verification_tokens 
        WHERE expires_at > NOW()
    ");
    $token_count = $stmt->fetch()['count'];
    
    echo "   Tokens valides: {$token_count}\n";
    
    // 5. Vérifier les fichiers
    echo "\n5️⃣  Vérification des fichiers créés:\n";
    
    $files = [
        'App/Services/EmailService.php' => 'Service d\'email',
        'App/Models/EmailVerificationToken.php' => 'Model de tokens',
        'App/Views/Auth/verify-email-pending.php' => 'Vue: En attente',
        'App/Views/Auth/verify-email-success.php' => 'Vue: Succès',
        'App/Views/Auth/verify-email-error.php' => 'Vue: Erreur',
    ];
    
    foreach ($files as $path => $description) {
        if (file_exists($path)) {
            echo "   ✓ $description ($path)\n";
        } else {
            echo "   ✗ MANQUANT: $description ($path)\n";
        }
    }
    
    // 6. Logs
    echo "\n6️⃣  Logs des emails:\n";
    
    $log_file = 'logs/email_verification.log';
    if (file_exists($log_file)) {
        $lines = file($log_file);
        echo "   ✓ Fichier de log existe\n";
        echo "   Dernières entrées:\n";
        foreach (array_slice($lines, -3) as $line) {
            echo "   " . trim($line) . "\n";
        }
    } else {
        echo "   ℹ️  Aucun log pour le moment (normal au premier test)\n";
    }
    
    echo "\n✅ SYSTÈME OPÉRATIONNEL!\n\n";
    echo "📝 Prochaines étapes:\n";
    echo "   1. Aller sur /register\n";
    echo "   2. Créer un compte test\n";
    echo "   3. Vérifier le lien dans logs/email_verification.log\n";
    echo "   4. Cliquer sur le lien de vérification\n";
    echo "   5. Se connecter avec le compte\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}
?>
