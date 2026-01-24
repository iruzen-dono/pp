-- ==========================================
-- NovaShop Pro - Données Premium Réalistes
-- ==========================================
-- Données complètes avec vraies images et descriptions détaillées

USE novashop;

-- ==========================================
-- 1. PURGER LES DONNÉES EXISTANTES
-- ==========================================

DELETE FROM order_items WHERE 1=1;
DELETE FROM orders WHERE 1=1;
DELETE FROM products WHERE 1=1;
DELETE FROM categories WHERE 1=1;
DELETE FROM users WHERE 1=1;

-- Reset auto-increment
ALTER TABLE users AUTO_INCREMENT = 1;
ALTER TABLE categories AUTO_INCREMENT = 1;
ALTER TABLE products AUTO_INCREMENT = 1;
ALTER TABLE orders AUTO_INCREMENT = 1;
ALTER TABLE order_items AUTO_INCREMENT = 1;

-- ==========================================
-- 2. INSÉRER LES UTILISATEURS
-- ==========================================

-- Admin NovaShop
-- Email: admin@novashop.local | Mot de passe: admin123
INSERT INTO users (name, email, password, role, created_at) VALUES 
('Alexandre Martin', 'admin@novashop.local', '$2y$10$ioclv8MtI9/7d/PCuak2AuD62.0FFY8Rq6pVG3Ccr79GD4rXV0Dmi', 'admin', NOW()),

-- Utilisateurs clients
('Marie Durand', 'marie.durand@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-06-15 10:30:00'),
('Jean Leclerc', 'jean.leclerc@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-07-20 14:45:00'),
('Sophie Bernard', 'sophie.bernard@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-08-10 09:15:00'),
('Thomas Petit', 'thomas.petit@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-09-05 16:20:00'),
('Isabelle Renard', 'isabelle.renard@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-09-18 11:30:00');

-- ==========================================
-- 3. INSÉRER LES CATÉGORIES
-- ==========================================

INSERT INTO categories (name, description, created_at) VALUES 
('Électronique', 'Appareils électroniques, ordinateurs portables, accessoires technologiques haute performance', NOW()),
('Mode & Vêtements', 'Vêtements tendance, accessoires de mode, collections exclusives pour tous les styles', NOW()),
('Livres & Publications', 'Littérature classique, livres techniques, publications éducatives et de développement personnel', NOW()),
('Maison & Décor', 'Mobilier, décoration intérieure, articles pour la maison, accessoires design', NOW()),
('Sports & Fitness', 'Équipements sportifs, vêtements de sport, accessoires fitness et wellness', NOW());

-- ==========================================
-- 4. INSÉRER LES PRODUITS - ÉLECTRONIQUE
-- ==========================================

INSERT INTO products (name, description, image_url, price, category_id, stock, created_at) VALUES 

-- Électronique - Ordinateurs
('MacBook Pro 16" M3 Max', 'Ordinateur portable professionnel avec processeur Apple M3 Max, 18 cœurs GPU, 36GB RAM, 1TB SSD. Écran Retina 3456x2234 pixels. Batterie 22h. Design premium en aluminium. Idéal pour les créatifs et développeurs.', '/Assets/Images/products/macbook_pro.png', 3499.99, 1, 8, NOW()),
('Dell XPS 13 Plus', 'Ultrabook ultra-léger 13.3" OLED 3K (120Hz), processeur Intel Core i7-13700H, 32GB RAM, 512GB SSD. Poids 2.7kg. Design futuriste sans bouton clavier. Parfait pour la mobilité.', '/Assets/Images/products/macbook_pro.png', 1899.99, 1, 5, NOW()),
('Lenovo ThinkPad X1 Carbon', 'Laptop affaires robuste 14" FHD, processeur Intel Core i7, 16GB RAM, 512GB SSD. Clavier mécanica premium. Certifié MIL-STD-810H. Batterie 15h. Parfait pour les professionnels.', '/Assets/Images/products/wireless_headphones.png', 1699.99, 1, 12, NOW()),

-- Électronique - Montres Intelligentes
('Apple Watch Ultra', 'Montre intelligente ultra-durable avec écran Retina LTPO OLED 49mm, batterie 36h, résistant aux chocs et l\'eau jusqu\'à 100m. Capteurs multiples: fréquence cardiaque, SPO2, température. Connectivité LTE.', '/Assets/Images/products/smartwatch.png', 899.99, 1, 15, NOW()),
('Samsung Galaxy Watch 6 Classic', 'Montre intelligente 47mm avec cadran rotatif, écran AMOLED 432x432px, batterie 3 jours, Wear OS 3.5, suivi santé complet. Design classique intemporel. Compatible Android et iOS.', '/Assets/Images/products/smartwatch.png', 449.99, 1, 20, NOW()),

-- Électronique - Casques Audio
('Sony WH-1000XM5', 'Casque Bluetooth premium avec réduction de bruit active IA, batterie 40h, son Hi-Res Audio. Microphone multi-directionnel. Certification IPX4. Confort toute journée grâce aux coussinets hypoallergéniques.', '/Assets/Images/products/wireless_headphones.png', 449.99, 1, 18, NOW()),
('Bose QuietComfort Ultra Earbuds', 'Écouteurs premium intra-auriculaires avec ANC ultra-efficace, batterie 6h (+24h avec étui), son spatial Dolby Atmos, multi-connectivité. Étui de charge premium. Design ergonomique.', '/Assets/Images/products/gaming_mouse.png', 299.99, 1, 25, NOW()),

-- Électronique - Écrans
('LG UltraWide 38" 3440x1440', 'Écran courbé ultrawide pour créatifs avec dalle Nano IPS, résolution 3440x1440 (21:9), taux rafraîchissement 175Hz, temps réaction 1ms. Contraste 1000:1. HDR600. Bras pivotant inclus.', '/Assets/Images/products/monitor_gaming.png', 1299.99, 1, 4, NOW()),
('BenQ PD2700U', 'Écran professionnel 27" 4K UHD (3840x2160), delta E < 2, couverture 99% Adobe RGB. Port USB-C avec Power Delivery. Support VESA. Idéal montage/photo.', '/Assets/Images/products/monitor_gaming.png', 699.99, 1, 7, NOW()),

-- Électronique - Webcam et Micros
('Logitech Brio 4K', 'Webcam 4K Ultra HD 1080p60fps, autofocus avancé, correction auto-éclairage. Microphone intégré à réduction de bruit. Champ vision 90°. RightLight 3 avec HDR. Compatible tous les OS.', '/Assets/Images/products/usb_hub.png', 199.99, 1, 22, NOW()),
('Shure SM7B', 'Microphone dynamique professionnel studio avec filtre anti-pop. Réponse fréquence 50Hz-20kHz. Rapport signal/bruit excellent. Bras articulé inclus. Standard industrie pour podcasts/studio.', '/Assets/Images/products/usb_hub.png', 399.99, 1, 10, NOW()),

-- ==========================================
-- 5. INSÉRER LES PRODUITS - MODE & VÊTEMENTS
-- ==========================================

('Veste Cuir Noir Premium', 'Veste en cuir véritable nappa noir, doublure en soie italienne, coupe cintrée moderne. Détails: poches intérieures zippées, fermeture YKK premium, ceinture ajustable. Tailles XS à XXL. Épaisseur 1.5mm.', '/Assets/Images/products/leather_jacket.png', 499.99, 2, 9, NOW()),
('Jeans Slim Bleu Délavé', 'Jeans premium coton stretch (98% coton, 2% élasthane), coupe slim moderne, teinture indigo naturelle. Rivets renforcés. Tailles 26-42. Couture française. Design intemporel.', '/Assets/Images/products/classic_jeans.png', 129.99, 2, 35, NOW()),
('Chemise Oxford Blanche', 'Chemise classique en coton oxford 100%, col button-down, double couture renforcée. Manches longues ajustables. Lavable machine. Coupe slim & regular. Tailles S-3XL.', '/Assets/Images/products/dress_elegant.png', 89.99, 2, 45, NOW()),
('T-Shirt Col V Premium', 'T-shirt premium en coton peigné 100%, col V profond, finitions surjetées. Grammage 180g/m². Couleurs solides et imprimés géométriques. Tailles XS-3XL. Idéal casual & semi-formel.', '/Assets/Images/products/sneakers_premium.png', 39.99, 2, 80, NOW()),
('Pull Laine Mérinos Gris', 'Pull en laine mérinos fine 100%, tricoté serré, thermorégulant naturel. Col rond. Poignets côtelés. Idéal automne/hiver. Non-piquant, hypoallergénique. Tailles XS-XL.', '/Assets/Images/products/scarf_silk.png', 159.99, 2, 20, NOW()),

('Sneakers Blanches Design', 'Baskets minimalistes cuir blanc premium avec détails gris. Semelle épaisse confortable EVA. Lacets contrastants. Design épuré. Tailles 36-46. Légères (290g pair).', '/Assets/Images/products/running_shoes.png', 149.99, 2, 40, NOW()),
('Accessoires Mode Ceinture', 'Ceinture en cuir noir premium boucle acier brossé. Largeur 3.5cm. Coutures renforcées. Tailles 75cm-130cm. Design intemporel classique.', '/Assets/Images/products/sunglasses_style.png', 69.99, 2, 50, NOW()),

-- ==========================================
-- 6. INSÉRER LES PRODUITS - LIVRES & PUBLICATIONS
-- ==========================================

('Clean Code - Robert Martin', 'Guide essentiel pour écrire du code lisible, maintenable et scalable. Analyse détaillée de 10+ cas réels. Exercices pratiques inclus. 464 pages. Édition 2008. Référence industrie.', '/Assets/Images/products/design_patterns.png', 49.99, 3, 18, NOW()),
('The Pragmatic Programmer', 'Conseils et astuces pour devenir un développeur plus productif. 352 pages. Édition révisée 2019. Couvre DevOps, design patterns, architecture. Écrit par Hunt & Thomas.', '/Assets/Images/products/design_patterns.png', 54.99, 3, 22, NOW()),
('Design Patterns - Gang of Four', 'La bible des patterns de conception. 395 pages. Explique 23 patterns essentiels avec exemples C++ & Java. Diagrammes UML détaillés. Incontournable pour architectes logiciels.', '/Assets/Images/products/design_patterns.png', 64.99, 3, 12, NOW()),

('Atomic Habits - James Clear', 'Construire meilleures habitudes et briser les mauvaises. Psychologie comportementale appliquée. 480 pages. Bestseller international. Exercices quotidiens. Science-based.', '/Assets/Images/products/clean_code.png', 28.99, 3, 35, NOW()),
('Zero to One - Peter Thiel', 'Créer l\'avenir en partant de zéro. Stratégie startup & innovation. 506 pages. Fondateur PayPal. Lessons de 20 ans entrepreneuriat. Édition 2014.', '/Assets/Images/products/clean_code.png', 35.99, 3, 25, NOW()),

('Python for Data Science', 'Maîtriser pandas, numpy, scikit-learn. 450 pages. Jupyter notebooks inclus. Data visualization avancée. Machine Learning fondamentals. Python 3.10+.', '/Assets/Images/products/clean_code.png', 59.99, 3, 16, NOW()),

-- ==========================================
-- 7. INSÉRER LES PRODUITS - MAISON & DÉCOR
-- ==========================================

('Lampe de Bureau LED Ajustable', 'Lampe LED premium avec 5 modes luminosité, température couleur ajustable 3000K-6500K. Bras flexible 360°. Batterie rechargeable USB. Port USB intégré pour charger téléphone. Consommation 5W.', '/Assets/Images/products/modern_lamp.png', 79.99, 4, 28, NOW()),
('Plante Monstera Artificielle', 'Plante artificielle haut de gamme réalisme extrême 120cm hauteur. Feuilles silicone détaillées. Pot céramique blanc mat inclus. Anti-UV pour extérieur. Entretien zéro.', '/Assets/Images/products/decorative_mirror.png', 89.99, 4, 15, NOW()),
('Miroir Mural Doré Octagonal', 'Miroir décoratif design octagonal cadre métal doré brossé. Diamètre 80cm. Verre miroir haute réflexion. Installation murale simple. Design art déco moderne.', '/Assets/Images/products/designer_chair.png', 199.99, 4, 8, NOW()),

('Chaise Ergonomique Gamer', 'Chaise bureau gaming avec appui-tête réglable, support lombaire. Matière respirante mesh. Hauteur assise 45-55cm. Accoudoirs ajustables 3D. Base renforcée 160kg. Roulettes silencieuses.', '/Assets/Images/products/designer_chair.png', 349.99, 4, 6, NOW()),
('Étagères Flottantes Design', 'Set 3 étagères flottantes chêne massif avec support acier noir. Dimensions 80x25x15cm. Support 25kg charge max/étagère. Installation murale incluse. Design minimaliste scandinave.', '/Assets/Images/products/modern_lamp.png', 149.99, 4, 12, NOW()),

('Tapis Persan Premium', 'Tapis persan authentique 200x300cm laine 100% teint naturel. Motifs géométriques traditionnels. Noeuds 200/m². Épaisseur 8mm. Résistant usure. Teinture fixée.', '/Assets/Images/products/persian_rug.png', 599.99, 4, 3, NOW()),

-- ==========================================
-- 8. INSÉRER LES PRODUITS - SPORTS & FITNESS
-- ==========================================

('Vélo Gravel Premium', 'Vélo gravel cadre carbone 56cm, groupe Shimano GRX 11v, roues 700c, suspension avant 50mm. Poids 8.5kg. Freins hydrauliques. Capacité bagages 100kg. Setup tout terrain & route.', '/Assets/Images/products/gravel_bike.png', 1899.99, 5, 4, NOW()),
('Haltères Ajustables 40kg', 'Paire d\'haltères réglables 2x20kg avec support. Plaques fonte recouverte caoutchouc. Ergonomique. Increment 2kg. Idéal home gym. Garantie 2 ans.', '/Assets/Images/products/dumbbells_set.png', 279.99, 5, 10, NOW()),
('Tapis de Yoga Premium', 'Tapis de yoga non-toxique TPE 183x61x6mm, antidérapant double face. Léger 1.5kg. Excellent grip sec & humide. Avec sangle transport. Couleurs naturelles.', '/Assets/Images/products/yoga_mat.png', 49.99, 5, 32, NOW()),

('Montre Fitness Garmin', 'Montre connectée sport multi-sports, écran AMOLED 1.2", batterie 11 jours. Capteurs: GPS, cardiaque, oxymètre, baromètre. Étanche 100m. Notifications smartwatch complètes.', '/Assets/Images/products/smartwatch.png', 349.99, 5, 14, NOW()),
('Chaussures Trail Running', 'Chaussures trail haute performance semelle Vibram, amorti CUSHIONIT, tige respirante mesh renforcé. Lacets anti-déverrouillage. Tailles 36-46. Poids 280g pair.', '/Assets/Images/products/running_shoes.png', 179.99, 5, 26, NOW()),

('Sac à Dos Trail 50L', 'Sac à dos rando 50L polyester 600D imperméable, suspension ajustable, ceinture de hanche rembourrée. Compartiment hydratation. Poches latérales. Poids vide 1.8kg. Montains proven.', '/Assets/Images/products/sunglasses_style.png', 149.99, 5, 18, NOW());

-- ==========================================
-- 9. INSÉRER QUELQUES COMMANDES POUR HISTORIQUE
-- ==========================================

INSERT INTO orders (user_id, total, status, created_at) VALUES 
(2, 679.98, 'delivered', '2025-09-01 08:15:00'),
(3, 1299.99, 'shipped', '2025-09-15 14:30:00'),
(4, 449.99, 'confirmed', '2025-09-20 11:45:00'),
(5, 879.97, 'pending', '2025-09-25 16:20:00'),
(6, 599.99, 'delivered', '2025-09-28 09:10:00');

-- Ajouter des articles aux commandes
INSERT INTO order_items (order_id, product_id, quantity, price) VALUES 
(1, 5, 1, 449.99),
(1, 14, 1, 229.99),
(2, 1, 1, 3499.99),
(3, 8, 1, 449.99),
(4, 24, 1, 349.99),
(4, 25, 1, 529.99),
(5, 12, 1, 599.99);

-- ==========================================
-- 10. VÉRIFICATIONS & STATISTIQUES
-- ==========================================

SELECT '✅ DONNÉES PREMIUM INSÉRÉES AVEC SUCCÈS!' AS Status;
SELECT '---' AS Separator;
SELECT CONCAT(COUNT(*), ' utilisateurs') AS Statistics FROM users;
SELECT CONCAT(COUNT(*), ' catégories') AS Statistics FROM categories;
SELECT CONCAT(COUNT(*), ' produits') AS Statistics FROM products;
SELECT CONCAT(COUNT(*), ' commandes') AS Statistics FROM orders;
SELECT CONCAT('€', FORMAT(SUM(total), 2), ' de ventes') AS Statistics FROM orders WHERE status IN ('delivered', 'shipped', 'confirmed');
SELECT '---' AS Separator;
SELECT '📊 Produits par catégorie:' AS Summary;
SELECT c.name, COUNT(p.id) as count FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.id, c.name;
