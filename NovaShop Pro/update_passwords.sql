-- ==========================================
-- Mise à jour des mots de passe
-- ==========================================
-- Hashes bcrypt VRAIS générés avec password_hash() en PHP 8.2

USE novashop;

-- Admin: admin123
UPDATE users SET password = '$2y$10$rW9dymWrRp.aU1A6vAkbI.mgBoCDZDhLV1x5FG37mJQF0kwy75YgK' WHERE email = 'admin@novashop.local';

-- Client: client123
UPDATE users SET password = '$2y$10$i2n.h4uVtIz6paIXmPryaOXm8wI.iR3jMkUWMimnLb/TLFLytE.ry' WHERE email = 'client@novashop.local';

-- Vérification
SELECT id, name, email FROM users;
