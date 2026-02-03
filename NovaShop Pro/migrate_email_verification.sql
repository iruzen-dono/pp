-- ==========================================
-- Migration: Ajout de la vérification email
-- ==========================================

-- 1. Ajouter les colonnes pour la vérification d'email
ALTER TABLE users ADD COLUMN IF NOT EXISTS email_verified_at TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE users ADD COLUMN IF NOT EXISTS is_active BOOLEAN DEFAULT FALSE;

-- 2. Créer la table de tokens de vérification
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Mettre à jour les utilisateurs existants comme vérifiés
UPDATE users SET is_active = TRUE, email_verified_at = created_at WHERE email_verified_at IS NULL;

-- ==========================================
-- Note: Après exécution, redémarrer l'application
-- ==========================================
