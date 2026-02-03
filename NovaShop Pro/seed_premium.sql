-- ==========================================
-- NovaShop Pro - Données Premium Réalistes
-- ==========================================
-- Données complètes avec vraies images et descriptions détaillées

-- Note: do not hardcode a database here; the import target is provided by the caller.
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


-- Admin NovaShop
INSERT INTO users (name, email, password, role, created_at) VALUES 
('Alexandre Martin', 'admin@novashop.local', '$2y$10$ioclv8MtI9/7d/PCuak2AuD62.0FFY8Rq6pVG3Ccr79GD4rXV0Dmi', 'admin', NOW()),

-- Utilisateurs clients
('Marie Durand', 'marie.durand@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-06-15 10:30:00'),
('Jean Leclerc', 'jean.leclerc@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-07-20 14:45:00'),
('Sophie Bernard', 'sophie.bernard@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-08-10 09:15:00'),
('Thomas Petit', 'thomas.petit@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-09-05 16:20:00'),
('Isabelle Renard', 'isabelle.renard@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user', '2025-09-18 11:30:00');

-- ==========================================
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
-- 4. INSÉRER LES PRODUITS - ÉLECTRONIQUE (7 produits)
-- ==========================================
INSERT INTO products (name, description, image_url, price, category_id, stock, created_at) VALUES 

('MacBook Pro 16" M3 Max', 'Ordinateur portable professionnel avec processeur Apple M3 Max, 18 cœurs GPU, 36GB RAM, 1TB SSD. Écran Retina 3456x2234 pixels. Batterie 22h. Design premium en aluminium. Idéal pour les créatifs et développeurs.', '/Assets/Images/products/product_1_v_a_tao_dwmpcfb5sg_unsplash.jpg', 3499.99, 1, 8, NOW()),
('LG UltraWide 38" 3440x1440', 'Écran courbé ultrawide pour créatifs avec dalle Nano IPS, résolution 3440x1440 (21:9), taux rafraîchissement 175Hz, temps réaction 1ms. Contraste 1000:1. HDR600. Bras pivotant inclus.', '/Assets/Images/products/product_2_luke_peters_rdxfszxybqu_unsplash.jpg', 1299.99, 1, 4, NOW()),
('Logitech Brio 4K', 'Webcam 4K Ultra HD 1080p60fps, autofocus avancé, correction auto-éclairage. Microphone intégré à réduction de bruit. Champ vision 90°. RightLight 3 avec HDR. Compatible tous les OS.', '/Assets/Images/products/product_3_franco_salcedo_1u2do0ne23q_unsplash.jpg', 199.99, 1, 22, NOW()),
('Shure SM7B', 'Microphone dynamique professionnel studio avec filtre anti-pop. Réponse fréquence 50Hz-20kHz. Rapport signal/bruit excellent. Bras articulé inclus. Standard industrie pour podcasts/studio.', '/Assets/Images/products/product_4_chris_lynch_qruwi3ur3ak_unsplash.jpg', 399.99, 1, 10, NOW()),
('Portable Charger 50000mAh', 'Batterie externe ultra-capacité 50000mAh, 2 ports USB + 1 USB-C. Charge rapide 65W. Écran LED. Compatible tous téléphones/tablettes. Poids 630g. Garantie 2 ans.', '/Assets/Images/products/product_5_rahul_chakraborty_tbko3ydz4hg_unsplash.jpg', 49.99, 1, 35, NOW()),
('Tablet Samsung Galaxy Tab', 'Tablette 12.9" AMOLED 2K, Snapdragon 8 Gen 2, 12GB RAM, 256GB stockage. Écran 90Hz. Batterie 13h. Stylet S Pen inclus. Haut-parleurs stéréo Dolby Atmos.', '/Assets/Images/products/product_6_shawn_rain_jt_nrgobcta_unsplash.jpg', 799.99, 1, 8, NOW()),
('BenQ PD2700U', 'Écran professionnel 27" 4K UHD (3840x2160), delta E < 2, couverture 99% Adobe RGB. Port USB-C avec Power Delivery. Support VESA. Idéal montage/photo.', '/Assets/Images/products/product_7_nitish_lakra_lrpdb487aos_unsplash.jpg', 699.99, 1, 7, NOW()),

-- Mode & Vêtements (10 produits)
('Veste Cuir Noir Premium', 'Veste en cuir véritable nappa noir, doublure en soie italienne, coupe cintrée moderne. Détails: poches intérieures zippées, fermeture YKK premium, ceinture ajustable. Tailles XS à XXL. Épaisseur 1.5mm.', '/Assets/Images/products/product_8_anna_evans_eelirbjxbpk_unsplash.jpg', 499.99, 2, 9, NOW()),
('Jeans Slim Bleu Délavé', 'Jeans premium coton stretch (98% coton, 2% élasthane), coupe slim moderne, teinture indigo naturelle. Rivets renforcés. Tailles 26-42. Couture française. Design intemporel.', '/Assets/Images/products/product_9_sona_aji_bhaskoro_th_kxzld_im_unsplash.jpg', 129.99, 2, 35, NOW()),
('Chemise Oxford Blanche', 'Chemise classique en coton oxford 100%, col button-down, double couture renforcée. Manches longues ajustables. Lavable machine. Coupe slim & regular. Tailles S-3XL.', '/Assets/Images/products/product_10_haryo_setyadi_acn5eraesb4_unsplash.jpg', 89.99, 2, 45, NOW()),
('T-Shirt Col V Premium', 'T-shirt premium en coton peigné 100%, col V profond, finitions surjetées. Grammage 180g/m². Couleurs solides et imprimés géométriques. Tailles XS-3XL. Idéal casual & semi-formel.', '/Assets/Images/products/fashion-needles-QRtWtyiU6cM-unsplash.jpg', 39.99, 2, 80, NOW()),
('Pull Laine Mérinos Gris', 'Pull en laine mérinos fine 100%, tricoté serré, thermorégulant naturel. Col rond. Poignets côtelés. Idéal automne/hiver. Non-piquant, hypoallergénique. Tailles XS-XL.', '/Assets/Images/products/faith-yarn-Wr0TpKqf26s-unsplash.jpg', 159.99, 2, 20, NOW()),
('Sneakers Blanches Design', 'Baskets minimalistes cuir blanc premium avec détails gris. Semelle épaisse confortable EVA. Lacets contrastants. Design épuré. Tailles 36-46. Légères (290g pair).', '/Assets/Images/products/nick-fewings-SEtiU4dGMkY-unsplash.jpg', 149.99, 2, 40, NOW()),
('Accessoires Mode Ceinture', 'Ceinture en cuir noir premium boucle acier brossé. Largeur 3.5cm. Coutures renforcées. Tailles 75cm-130cm. Design intemporel classique.', '/Assets/Images/products/dries-de-schepper-j8fFee11sHU-unsplash.jpg', 69.99, 2, 50, NOW()),
('Montre Designer Homme', 'Montre de luxe boîtier acier inoxydable 42mm, mouvement suisse, bracelet en cuir italien. Cadran noir mat. Résistant 100m. Garantie 5 ans.', '/Assets/Images/products/kobu-agency-ipARHaxETRk-unsplash.jpg', 399.99, 2, 12, NOW()),
('Lunettes Soleil Aviateur', 'Lunettes de soleil aviateur verres polarisés anti-UV, monture acier doré, verre dégradé. Design classique intemporel. Protection 100% UV400.', '/Assets/Images/products/marlon-corona-1tMc27CFUbA-unsplash.jpg', 89.99, 2, 32, NOW()),
('Écharpe Soie Premium', 'Écharpe légère en soie naturelle 100%, motifs géométriques discrets. Dimensions 180x45cm. Couleurs neutres. Idéal accessoire élégant toutes saisons.', '/Assets/Images/products/sevda-afshar-vkCmm43EfTc-unsplash.jpg', 79.99, 2, 25, NOW()),

-- ==========================================
-- 6. INSÉRER LES PRODUITS - LIVRES & PUBLICATIONS (8 produits)
-- ==========================================
('Clean Code - Robert Martin', 'Guide essentiel pour écrire du code lisible, maintenable et scalable. Analyse détaillée de 10+ cas réels. Exercices pratiques inclus. 464 pages. Édition 2008. Référence industrie.', '/Assets/Images/products/markus-spiske-1LLh8k2_YFk-unsplash.jpg', 49.99, 3, 18, NOW()),
('The Pragmatic Programmer', 'Conseils et astuces pour devenir un développeur plus productif. 352 pages. Édition révisée 2019. Couvre DevOps, design patterns, architecture. Écrit par Hunt & Thomas.', '/Assets/Images/products/markus-winkler-f57lx37DCM4-unsplash.jpg', 54.99, 3, 22, NOW()),
('Design Patterns - Gang of Four', 'La bible des patterns de conception. 395 pages. Explique 23 patterns essentiels avec exemples C++ & Java. Diagrammes UML détaillés. Incontournable pour architectes logiciels.', '/Assets/Images/products/nubelson-fernandes-rfoH17_F7F8-unsplash.jpg', 64.99, 3, 12, NOW()),
('Atomic Habits - James Clear', 'Construire meilleures habitudes et briser les mauvaises. Psychologie comportementale appliquée. 480 pages. Bestseller international. Exercices quotidiens. Science-based.', '/Assets/Images/products/loganathan-logesh-uA1bZsgrTTs-unsplash.jpg', 28.99, 3, 35, NOW()),
('Zero to One - Peter Thiel', 'Créer l\'avenir en partant de zéro. Stratégie startup & innovation. 506 pages. Fondateur PayPal. Lessons de 20 ans entrepreneuriat. Édition 2014.', '/Assets/Images/products/lautaro-andreani-xkBaqlcqeb4-unsplash.jpg', 35.99, 3, 25, NOW()),
('Python for Data Science', 'Maîtriser pandas, numpy, scikit-learn. 450 pages. Jupyter notebooks inclus. Data visualization avancée. Machine Learning fondamentals. Python 3.10+.', '/Assets/Images/products/madeinegypt-ca-kpyz_oL7mP0-unsplash.jpg', 59.99, 3, 16, NOW()),
('Web Development with React', 'Maîtriser React, Redux, et Next.js. Projets fullstack pratiques. 520 pages. Exemples E-commerce réaliste. Pour débutants à avancés.', '/Assets/Images/products/mathilde-langevin--sZ_WM4cOlM-unsplash.jpg', 49.99, 3, 19, NOW()),
('Machine Learning Foundations', 'Introduction complète au machine learning avec Python. 512 pages. Théorie et pratique équilibrées. Datasets réalistes. Édition 2023.', '/Assets/Images/products/shino-nakamura-7_TixXDAUZ8-unsplash.jpg', 54.99, 3, 14, NOW()),

-- ==========================================
-- 7. INSÉRER LES PRODUITS - MAISON & DÉCOR & SPORTS (10 produits)
-- ==========================================
('Lampe de Bureau LED Ajustable', 'Lampe LED premium avec 5 modes luminosité, température couleur ajustable 3000K-6500K. Bras flexible 360°. Batterie rechargeable USB. Port USB intégré pour charger téléphone. Consommation 5W.', '/Assets/Images/products/puscas-adryan-kpwmh_9OtG4-unsplash.jpg', 79.99, 4, 28, NOW()),
('Plante Monstera Artificielle', 'Plante artificielle haut de gamme réalisme extrême 120cm hauteur. Feuilles silicone détaillées. Pot céramique blanc mat inclus. Anti-UV pour extérieur. Entretien zéro.', '/Assets/Images/products/feey-tDnlNLK_3dk-unsplash.jpg', 89.99, 4, 15, NOW()),
('Miroir Mural Doré Octagonal', 'Miroir décoratif design octagonal cadre métal doré brossé. Diamètre 80cm. Verre miroir haute réflexion. Installation murale simple. Design art déco moderne.', '/Assets/Images/products/roger-bradshaw-Y6L_zTbSmbs-unsplash.jpg', 199.99, 4, 8, NOW()),
('Étagères Flottantes Design', 'Set 3 étagères flottantes chêne massif avec support acier noir. Dimensions 80x25x15cm. Support 25kg charge max/étagère. Installation murale incluse. Design minimaliste scandinave.', '/Assets/Images/products/sj-2hwhvm0WyW0-unsplash.jpg', 149.99, 4, 12, NOW()),
('Fauteuil Lounge Scandinave', 'Fauteuil confortable cuir synthétique marron, pieds bois naturel chêne. Dimensionscompactes 85x80cm. Rembourrage mousse haute densité. Design intemporel scandinave.', '/Assets/Images/products/ayanda-kunene-DgMjb21sEUI-unsplash.jpg', 299.99, 4, 5, NOW()),
('Tapis Persan Premium', 'Tapis persan authentique 200x300cm laine 100% teinture naturelle. Motifs géométriques. Noeuds 200/m². Épaisseur 8mm. Luxe et durabilité.', '/Assets/Images/products/victoria-berman-nLNimOqmbpg-unsplash.jpg', 599.99, 4, 3, NOW()),

('Vélo Gravel Premium', 'Vélo gravel cadre carbone 56cm, groupe Shimano GRX 11v, roues 700c, suspension avant 50mm. Poids 8.5kg. Freins hydrauliques. Capacité bagages 100kg. Setup tout terrain & route.', '/Assets/Images/products/himiway-bikes-oq_hv-oG58w-unsplash.jpg', 1899.99, 5, 4, NOW()),
('Tapis de Yoga Premium', 'Tapis de yoga non-toxique TPE 183x61x6mm, antidérapant double face. Léger 1.5kg. Excellent grip sec & humide. Avec sangle transport. Couleurs naturelles.', '/Assets/Images/products/karl-kohler-dGIEMeN2MV8-unsplash.jpg', 49.99, 5, 32, NOW()),
('Chaussures Trail Running', 'Chaussures trail haute performance semelle Vibram, amorti CUSHIONIT, tige respirante mesh renforcé. Lacets anti-déverrouillage. Tailles 36-46. Poids 280g pair.', '/Assets/Images/products/swabdesign-JwZ3GhXo8g4-unsplash.jpg', 179.99, 5, 26, NOW()),
('Gourde Isotherme Inox', 'Gourde isotherme double paroi 750ml, acier inoxydable brossé. Garde boisson 24h froide ou 12h chaude. Bouchon étanche sans BPA. Compatible porte-gobelet voiture.', '/Assets/Images/products/deon-collison-Rk62VPlcZqw-unsplash.jpg', 34.99, 5, 40, NOW());


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


SELECT '✅ DONNÉES PREMIUM INSÉRÉES AVEC SUCCÈS!' AS Status;
SELECT '---' AS Separation;
SELECT CONCAT(COUNT(*), ' utilisateurs') AS Statistics FROM users;
SELECT CONCAT(COUNT(*), ' catégories') AS Statistics FROM categories;
SELECT CONCAT(COUNT(*), ' produits') AS Statistics FROM products;
SELECT CONCAT(COUNT(*), ' commandes') AS Statistics FROM orders;
SELECT CONCAT('€', FORMAT(SUM(total), 2), ' de ventes') AS Statistics FROM orders WHERE status IN ('delivered', 'shipped', 'confirmed');
SELECT '---' AS Separation;
SELECT '📊 Produits par catégorie:' AS Summary;
SELECT c.name, COUNT(p.id) as count FROM categories c LEFT JOIN products p ON c.id = p.category_id GROUP BY c.id, c.name;