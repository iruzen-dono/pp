<?php
require 'App/Config/Database.php';
use App\Config\Database;

try {
    $pdo = Database::getConnection();
    
    echo "╔════════════════════════════════════════════════╗\n";
    echo "║   Exécution de la Migration Email Verification ║\n";
    echo "╚════════════════════════════════════════════════╝\n\n";
    
    // 1. Ajouter les colonnes pour la vérification d'email
    echo "1️⃣  Ajout des colonnes email_verified_at et is_active...\n";
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN email_verified_at TIMESTAMP NULL DEFAULT NULL");
        echo "   ✓ Colonne email_verified_at ajoutée\n";
    } catch (\Exception $e) {
        echo "   ℹ️  Colonne email_verified_at existe déjà\n";
    }
    
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN is_active BOOLEAN DEFAULT FALSE");
        echo "   ✓ Colonne is_active ajoutée\n";
    } catch (\Exception $e) {
        echo "   ℹ️  Colonne is_active existe déjà\n";
    }
    
    // 2. Créer la table de tokens de vérification
    echo "\n2️⃣  Création de la table email_verification_tokens...\n";
    try {
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS email_verification_tokens (
                id INT AUTO_INCREMENT PRIMARY KEY,
                user_id INT NOT NULL,
                token VARCHAR(255) NOT NULL UNIQUE,
                expires_at TIMESTAMP NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
                INDEX idx_user (user_id),
                INDEX idx_token (token),
                INDEX idx_expires (expires_at)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "   ✓ Table email_verification_tokens créée\n";
    } catch (\Exception $e) {
        echo "   ℹ️  Table email_verification_tokens existe déjà\n";
    }
    
    // 3. Mettre à jour les utilisateurs existants
    echo "\n3️⃣  Mise à jour des utilisateurs existants...\n";
    $updated = $pdo->exec("UPDATE users SET is_active = TRUE, email_verified_at = created_at WHERE email_verified_at IS NULL");
    echo "   ✓ $updated utilisateur(s) mis à jour\n";
    
    echo "\n✅ Migration terminée avec succès!\n";
    echo "\n📧 Configuration de l'authentification par email:\n";
    echo "   - Les nouveaux utilisateurs reçoivent un email de confirmation\n";
    echo "   - Ils doivent cliquer sur le lien pour activer leur compte\n";
    echo "   - Pendant le développement, les liens sont loggés dans logs/email_verification.log\n";
    echo "   - Les anciens utilisateurs restent actifs\n";
    
} catch (\Exception $e) {
    echo "❌ Erreur: " . $e->getMessage() . "\n";
}
?>
