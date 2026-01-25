-- ==========================================
-- NovaShop Pro - Données Premium (35 produits)
-- ==========================================
-- 7 produits par catégorie : Électronique, Mode, Livres, Maison, Sports

USE novashop;

-- Ajouter la catégorie Sports si nécessaire
INSERT IGNORE INTO categories (name, description) VALUES
('Sports', 'Articles de sport et équipements fitness');

-- ==========================================
-- 35 PRODUITS PREMIUM (7 par catégorie)
-- ==========================================

INSERT INTO products (name, description, image_url, price, category_id, stock, created_at) VALUES 

-- ÉLECTRONIQUE (7 produits)
('MacBook Pro 16" M3 Max', 'Ordinateur portable professionnel avec processeur Apple M3 Max, 18 cœurs GPU, 36GB RAM, 1TB SSD. Écran Retina 3456x2234. Batterie 22h. Design premium aluminium.', '/Assets/Images/products/macbook_pro.png', 3499.99, 1, 8, NOW()),
('Dell XPS 13 Plus', 'Ultrabook ultra-léger 13.3" OLED 3K (120Hz), processeur Intel Core i7, 32GB RAM, 512GB SSD. Poids 2.7kg. Design futuriste.', '/Assets/Images/products/dell_xps.png', 1899.99, 1, 5, NOW()),
('Apple Watch Ultra', 'Montre intelligente ultra-durable écran LTPO OLED 49mm, batterie 36h, résistant 100m. Capteurs: fréquence cardiaque, SPO2, température. LTE.', '/Assets/Images/products/apple_watch.png', 899.99, 1, 15, NOW()),
('Sony WH-1000XM5', 'Casque Bluetooth premium réduction bruit active IA, batterie 40h, son Hi-Res Audio. Multi-directionnel. IPX4. Hypoallergénique.', '/Assets/Images/products/sony_headphones.png', 449.99, 1, 18, NOW()),
('LG UltraWide 38" 3440x1440', 'Écran courbé ultrawide dalle Nano IPS, résolution 3440x1440 (21:9), 175Hz, 1ms. Contraste 1000:1. HDR600. Bras pivotant.', '/Assets/Images/products/lg_ultrawide.png', 1299.99, 1, 4, NOW()),
('Samsung Galaxy Tab S9', 'Tablette 12.9" AMOLED 2K, Snapdragon 8 Gen 2, 12GB RAM, 256GB. Écran 90Hz. Batterie 13h. Stylet S Pen. Dolby Atmos.', '/Assets/Images/products/tablet.png', 799.99, 1, 8, NOW()),
('Portable Charger 50000mAh', 'Batterie externe ultra-capacité, 2 ports USB + USB-C. Charge rapide 65W. Compatible tous téléphones/tablettes. Garantie 2 ans.', '/Assets/Images/products/power_bank.png', 49.99, 1, 35, NOW()),

-- MODE & VÊTEMENTS (7 produits)
('Veste Cuir Noir Premium', 'Veste cuir véritable nappa noir, doublure soie italienne, coupe cintrée. Poches intérieures zippées, fermeture YKK premium. Tailles XS-XXL.', '/Assets/Images/products/leather_jacket.png', 499.99, 2, 9, NOW()),
('Jeans Slim Bleu Délavé', 'Jeans premium coton stretch (98% coton), coupe slim moderne, teinture indigo naturelle. Rivets renforcés. Tailles 26-42. Couture française.', '/Assets/Images/products/jeans.png', 129.99, 2, 35, NOW()),
('Chemise Oxford Blanche', 'Chemise classique coton oxford 100%, col button-down, double couture renforcée. Manches ajustables. Tailles S-3XL. Lavable machine.', '/Assets/Images/products/shirt.png', 89.99, 2, 45, NOW()),
('Pull Laine Mérinos Gris', 'Pull laine mérinos fine 100%, tricoté serré, thermorégulant naturel. Non-piquant, hypoallergénique. Tailles XS-XL.', '/Assets/Images/products/sweater.png', 159.99, 2, 20, NOW()),
('Sneakers Blanches Design', 'Baskets minimalistes cuir blanc premium, détails gris. Semelle EVA. Lacets contrastants. Tailles 36-46. Légères 290g pair.', '/Assets/Images/products/sneakers.png', 149.99, 2, 40, NOW()),
('Montre Designer Homme', 'Montre luxe boîtier acier inoxydable 42mm, mouvement suisse, bracelet cuir italien. Cadran noir mat. Résistant 100m. Garantie 5 ans.', '/Assets/Images/products/watch.png', 399.99, 2, 12, NOW()),
('Lunettes Soleil Aviateur', 'Lunettes aviateur verres polarisés anti-UV, monture acier doré, verre dégradé. Protection 100% UV400. Design classique intemporel.', '/Assets/Images/products/sunglasses.png', 89.99, 2, 32, NOW()),

-- LIVRES & ÉDUCATION (7 produits)
('Clean Code - Robert Martin', 'Guide essentiel code lisible, maintenable et scalable. Analyse 10+ cas réels. Exercices pratiques. 464 pages. Édition 2008. Référence industrie.', '/Assets/Images/products/clean_code.png', 49.99, 3, 18, NOW()),
('The Pragmatic Programmer', 'Conseils développeur productif. 352 pages. Édition 2019. DevOps, design patterns, architecture. Hunt & Thomas.', '/Assets/Images/products/pragmatic.png', 54.99, 3, 22, NOW()),
('Design Patterns - Gang of Four', 'Bible patterns conception. 395 pages. 23 patterns essentiels C++ & Java. Diagrammes UML. Incontournable architectes.', '/Assets/Images/products/design_patterns.png', 64.99, 3, 12, NOW()),
('Atomic Habits - James Clear', 'Construire habitudes, briser mauvaises. Psychologie comportementale. 480 pages. Bestseller. Exercices quotidiens.', '/Assets/Images/products/atomic_habits.png', 28.99, 3, 35, NOW()),
('Zero to One - Peter Thiel', 'Créer avenir partant zéro. Stratégie startup & innovation. 506 pages. Fondateur PayPal. 20 ans entrepreneuriat.', '/Assets/Images/products/zero_to_one.png', 35.99, 3, 25, NOW()),
('Python for Data Science', 'Maîtriser pandas, numpy, scikit-learn. 450 pages. Jupyter notebooks. Data visualization. Machine Learning. Python 3.10+.', '/Assets/Images/products/python_ds.png', 59.99, 3, 16, NOW()),
('Web Development with React', 'Maîtriser React, Redux, Next.js. 520 pages. Projets fullstack. E-commerce réaliste. Débutants à avancés.', '/Assets/Images/products/react_book.png', 49.99, 3, 19, NOW()),

-- MAISON & DÉCOR (7 produits)
('Lampe de Bureau LED Ajustable', 'Lampe LED premium 5 modes luminosité, température couleur 3000K-6500K. Bras flexible 360°. Batterie USB rechargeable. Port USB intégré.', '/Assets/Images/products/desk_lamp.png', 79.99, 4, 28, NOW()),
('Plante Monstera Artificielle', 'Plante artificielle réalisme extrême 120cm. Feuilles silicone détaillées. Pot céramique blanc inclus. Anti-UV. Entretien zéro.', '/Assets/Images/products/artificial_plant.png', 89.99, 4, 15, NOW()),
('Miroir Mural Doré Octagonal', 'Miroir décor octagonal cadre métal doré brossé. Diamètre 80cm. Verre haute réflexion. Installation simple. Design art déco.', '/Assets/Images/products/mirror.png', 199.99, 4, 8, NOW()),
('Chaise Ergonomique Gamer', 'Chaise bureau gaming appui-tête réglable, support lombaire. Mesh respirant. Hauteur 45-55cm. Accoudoirs 3D. Base 160kg.', '/Assets/Images/products/gaming_chair.png', 349.99, 4, 6, NOW()),
('Étagères Flottantes Design', 'Set 3 étagères chêne massif support acier noir. 80x25x15cm. Support 25kg/étagère. Installation murale. Design scandinave.', '/Assets/Images/products/shelves.png', 149.99, 4, 12, NOW()),
('Tapis Persan Premium', 'Tapis persan authentique 200x300cm laine 100% teinture naturelle. Motifs géométriques. Noeuds 200/m². Épaisseur 8mm.', '/Assets/Images/products/rug.png', 599.99, 4, 3, NOW()),
('Bibliothèque Bois Massif', 'Bibliothèque design chêne massif 180x90x30cm, 5 étages, capacité 150kg. Finition huilée naturelle. Assemblage DIY.', '/Assets/Images/products/bookshelf.png', 299.99, 4, 5, NOW()),

-- SPORTS & FITNESS (7 produits)
('Vélo Gravel Premium', 'Vélo gravel cadre carbone 56cm, groupe Shimano GRX 11v, roues 700c, suspension 50mm. Poids 8.5kg. Bagages 100kg.', '/Assets/Images/products/gravel_bike.png', 1899.99, 5, 4, NOW()),
('Haltères Ajustables 40kg', 'Paire haltères réglables 2x20kg support. Fonte recouverte caoutchouc. Ergonomique. Increment 2kg. Home gym. Garantie 2 ans.', '/Assets/Images/products/dumbbells.png', 279.99, 5, 10, NOW()),
('Tapis de Yoga Premium', 'Tapis yoga TPE 183x61x6mm, antidérapant double face. Léger 1.5kg. Excellent grip sec & humide. Avec sangle transport.', '/Assets/Images/products/yoga_mat.png', 49.99, 5, 32, NOW()),
('Montre Fitness Garmin', 'Montre sport multi-sports écran AMOLED 1.2", batterie 11 jours. GPS, cardiaque, oxymètre, baromètre. Étanche 100m.', '/Assets/Images/products/garmin_watch.png', 349.99, 5, 14, NOW()),
('Chaussures Trail Running', 'Chaussures trail semelle Vibram, amorti CUSHIONIT. Mesh renforcé. Lacets anti-déverrouillage. Tailles 36-46. 280g pair.', '/Assets/Images/products/trail_shoes.png', 179.99, 5, 26, NOW()),
('Sac à Dos Trail 50L', 'Sac 50L polyester 600D imperméable, suspension ajustable, ceinture hanche rembourrée. Compartiment hydratation. 1.8kg.', '/Assets/Images/products/backpack.png', 149.99, 5, 18, NOW()),
('Kettlebell Fonte Premium', 'Kettlebell 24kg fonte brute, poignée lisse ergonomique. Surface anti-rouille. Base stable. Idéal crossfit & functional.', '/Assets/Images/products/kettlebell.png', 89.99, 5, 20, NOW());

-- ==========================================
-- VÉRIFICATIONS
-- ==========================================
SELECT '✅ DONNÉES PREMIUM INSÉRÉES!' AS Status;
SELECT CONCAT(COUNT(*), ' produits au total') AS Statistics FROM products;
SELECT CONCAT('€', FORMAT(SUM(price * stock), 2), ' de stock') AS Statistics FROM products;
