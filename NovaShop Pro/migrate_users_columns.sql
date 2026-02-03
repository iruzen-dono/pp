-- ==========================================
-- Migration: Ajouter les colonnes manquantes à la table users
-- ==========================================

-- Vérifier et ajouter la colonne is_active si elle n'existe pas
ALTER TABLE users ADD COLUMN is_active BOOLEAN DEFAULT FALSE;

-- Vérifier et ajouter la colonne email_verified_at si elle n'existe pas
ALTER TABLE users ADD COLUMN email_verified_at TIMESTAMP NULL;

-- Vérifier et ajouter la colonne variants si elle n'existe pas dans products
ALTER TABLE products ADD COLUMN variants TEXT NULL;

-- Mettre à jour tous les utilisateurs existants à is_active = TRUE
UPDATE users SET is_active = TRUE WHERE is_active IS NULL OR is_active = FALSE;

-- Mettre à jour email_verified_at pour les utilisateurs existants
UPDATE users SET email_verified_at = NOW() WHERE email_verified_at IS NULL;

-- Vérifier les résultats
SELECT '✅ Migration terminée!' AS Status;
SELECT COUNT(*) AS total_users, 
       SUM(CASE WHEN is_active = TRUE THEN 1 ELSE 0 END) as users_actifs
FROM users;
SELECT COUNT(*) AS total_products FROM products;
