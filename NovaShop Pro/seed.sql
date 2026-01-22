-- ==========================================
-- NovaShop Pro - Données de test (Seed)
-- ==========================================
-- Insérer des données pour tester l'application

USE novashop;

-- ==========================================
-- 1. INSÉRER DES UTILISATEURS
-- ==========================================

-- Admin (role = admin)
-- Email: admin@novashop.local
-- Mot de passe: admin123 (hashé avec bcrypt)
INSERT INTO users (name, email, password, role) VALUES 
('Admin NovaShop', 'admin@novashop.local', '$2y$10$G7a5pHH.wN/1C6nWYYZr4.BrLB0CXQZ7Qy5Y3Z3Z3Z3Z3Z3Z3Z3Z3', 'admin');

-- Client normal (role = user)
-- Email: client@novashop.local
-- Mot de passe: client123 (hashé avec bcrypt)
INSERT INTO users (name, email, password, role) VALUES 
('Jean Dupont', 'client@novashop.local', '$2y$10$M8b6pKI.xO/2D7oXZZar5.CsMC1DYRA8Rz6Z4a4a4a4a4a4a4a4a4', 'user');

-- ==========================================
-- 2. INSÉRER DES CATÉGORIES
-- ==========================================

INSERT INTO categories (name, description) VALUES 
('Électronique', 'Appareils électroniques et gadgets'),
('Vêtements', 'Vêtements et accessoires'),
('Livres', 'Livres et publications'),
('Maison & Décor', 'Articles pour la maison'),
('Sports & Loisirs', 'Équipements de sport et loisirs');

-- ==========================================
-- 3. INSÉRER DES PRODUITS
-- ==========================================

-- Électronique
INSERT INTO products (name, description, price, category_id, stock) VALUES 
('Laptop Asus VivoBook', 'Laptop performant avec processeur Intel Core i7, 8GB RAM, 512GB SSD. Idéal pour le travail et les jeux légers.', 899.99, 1, 5),
('Casque Bluetooth Sony', 'Casque sans fil avec réduction de bruit active. Batterie 30h, son haute qualité.', 199.99, 1, 12),
('Écran 27 pouces 4K', 'Écran UHD pour un travail professionnel ou du gaming. Dalle IPS, 60Hz, connectivité USB-C.', 449.99, 1, 3);

-- Vêtements
INSERT INTO products (name, description, price, category_id, stock) VALUES 
('T-shirt Coton Premium', 'T-shirt de qualité supérieure en coton 100%. Confortable et durable. Disponible en plusieurs couleurs.', 29.99, 2, 50),
('Jeans Slim Fit', 'Jeans bleu marine avec coupe slim moderne. Matière stretch confortable. Taille 28 à 40.', 79.99, 2, 30),
('Veste Cuir Noir', 'Veste en cuir véritable, style casual. Doublure intérieure confortable. Tailles S à XL.', 249.99, 2, 8);

-- Livres
INSERT INTO products (name, description, price, category_id, stock) VALUES 
('Clean Code - Robert Martin', 'Guide essentiel pour écrire un code lisible et maintenable. Incontournable pour les développeurs.', 45.99, 3, 15),
('The Pragmatic Programmer', 'Conseils pratiques pour améliorer vos compétences en programmation. Édition mise à jour 2020.', 52.99, 3, 20);

-- ==========================================
-- 4. VÉRIFICATION
-- ==========================================

SELECT '✅ Données insérées avec succès!' AS status;
SELECT COUNT(*) as 'Utilisateurs' FROM users;
SELECT COUNT(*) as 'Catégories' FROM categories;
SELECT COUNT(*) as 'Produits' FROM products;
