<?php
/**
 * Direct Premium Data Importer
 * Importe directement les données premium en utilisant du code PHP
 */

// Configuration de la base de données
$config = [
    'localhost' => ['root', '0000'],
    '127.0.0.1' => ['root', '0000'],
];

$pdo = null;
foreach ($config as $host => $creds) {
    try {
        $pdo = new PDO(
            "mysql:host=$host;dbname=novashop;charset=utf8mb4",
            $creds[0],
            $creds[1],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
            ]
        );
        echo "✅ Connexion à la base de données réussie!\n";
        break;
    } catch (PDOException $e) {
        continue;
    }
}

if ($pdo === null) {
    echo "❌ Impossible de se connecter à la base de données\n";
    exit(1);
}

// Vider les tables
echo "🗑️  Nettoyage des données existantes...\n";
try {
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0");
    $pdo->exec("TRUNCATE TABLE order_items");
    $pdo->exec("TRUNCATE TABLE orders");
    $pdo->exec("TRUNCATE TABLE products");
    $pdo->exec("TRUNCATE TABLE categories");
    $pdo->exec("TRUNCATE TABLE users");
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1");
} catch (Exception $e) {
    echo "⚠️  Avertissement: " . $e->getMessage() . "\n";
}

// ==========================================
// 1. INSÉRER LES UTILISATEURS
// ==========================================
echo "👥 Insertion des utilisateurs...\n";

$users = [
    ['Alexandre Martin', 'admin@novashop.local', '$2y$10$ioclv8MtI9/7d/PCuak2AuD62.0FFY8Rq6pVG3Ccr79GD4rXV0Dmi', 'admin'],
    ['Marie Durand', 'marie.durand@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
    ['Jean Leclerc', 'jean.leclerc@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
    ['Sophie Bernard', 'sophie.bernard@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
    ['Thomas Petit', 'thomas.petit@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
    ['Isabelle Renard', 'isabelle.renard@email.com', '$2y$10$njIGZ/pnkst9/ihIIysVGuR3dfRN4r1Xr17gPqgAf8mxF6G8fc9cq', 'user'],
];

$stmt = $pdo->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
foreach ($users as $user) {
    $stmt->execute($user);
}
echo "  ✅ {" . count($users) . "} utilisateurs insérés\n";

// ==========================================
// 2. INSÉRER LES CATÉGORIES
// ==========================================
echo "📂 Insertion des catégories...\n";

$categories = [
    ['Électronique', 'Appareils électroniques, ordinateurs portables, accessoires technologiques haute performance'],
    ['Mode & Vêtements', 'Vêtements tendance, accessoires de mode, collections exclusives pour tous les styles'],
    ['Livres & Publications', 'Littérature classique, livres techniques, publications éducatives et de développement personnel'],
    ['Maison & Décor', 'Mobilier, décoration intérieure, articles pour la maison, accessoires design'],
    ['Sports & Fitness', 'Équipements sportifs, vêtements de sport, accessoires fitness et wellness'],
];

$stmt = $pdo->prepare("INSERT INTO categories (name, description) VALUES (?, ?)");
foreach ($categories as $category) {
    $stmt->execute($category);
}
echo "  ✅ {" . count($categories) . "} catégories insérées\n";

// ==========================================
// 3. INSÉRER LES PRODUITS
// ==========================================
echo "🛍️  Insertion des produits...\n";

$products = [
    // Électronique (10)
    ['MacBook Pro 16" M3 Max', 'Ordinateur portable professionnel avec processeur Apple M3 Max, 18 cœurs GPU, 36GB RAM, 1TB SSD. Écran Retina 3456x2234 pixels. Batterie 22h. Design premium en aluminium. Idéal pour les créatifs et développeurs.', 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=500&h=500&fit=crop', 3499.99, 1, 8],
    ['Dell XPS 13 Plus', 'Ultrabook ultra-léger 13.3" OLED 3K (120Hz), processeur Intel Core i7-13700H, 32GB RAM, 512GB SSD. Poids 2.7kg. Design futuriste sans bouton clavier. Parfait pour la mobilité.', 'https://images.unsplash.com/photo-1588872657840-e5d3d701d819?w=500&h=500&fit=crop', 1899.99, 1, 5],
    ['Lenovo ThinkPad X1 Carbon', 'Laptop affaires robuste 14" FHD, processeur Intel Core i7, 16GB RAM, 512GB SSD. Clavier mécanica premium. Certifié MIL-STD-810H. Batterie 15h. Parfait pour les professionnels.', 'https://images.unsplash.com/photo-1593642632823-8f785ba67e45?w=500&h=500&fit=crop', 1699.99, 1, 12],
    ['Apple Watch Ultra', 'Montre intelligente ultra-durable avec écran Retina LTPO OLED 49mm, batterie 36h, résistant aux chocs et l\'eau jusqu\'à 100m. Capteurs multiples: fréquence cardiaque, SPO2, température. Connectivité LTE.', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop', 899.99, 1, 15],
    ['Samsung Galaxy Watch 6 Classic', 'Montre intelligente 47mm avec cadran rotatif, écran AMOLED 432x432px, batterie 3 jours, Wear OS 3.5, suivi santé complet. Design classique intemporel. Compatible Android et iOS.', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop', 449.99, 1, 20],
    ['Sony WH-1000XM5', 'Casque Bluetooth premium avec réduction de bruit active IA, batterie 40h, son Hi-Res Audio. Microphone multi-directionnel. Certification IPX4. Confort toute journée grâce aux coussinets hypoallergéniques.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=500&h=500&fit=crop', 449.99, 1, 18],
    ['Bose QuietComfort Ultra Earbuds', 'Écouteurs premium intra-auriculaires avec ANC ultra-efficace, batterie 6h (+24h avec étui), son spatial Dolby Atmos, multi-connectivité. Étui de charge premium. Design ergonomique.', 'https://images.unsplash.com/photo-1484704849700-f032a568e944?w=500&h=500&fit=crop', 299.99, 1, 25],
    ['LG UltraWide 38" 3440x1440', 'Écran courbé ultrawide pour créatifs avec dalle Nano IPS, résolution 3440x1440 (21:9), taux rafraîchissement 175Hz, temps réaction 1ms. Contraste 1000:1. HDR600. Bras pivotant inclus.', 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?w=500&h=500&fit=crop', 1299.99, 1, 4],
    ['BenQ PD2700U', 'Écran professionnel 27" 4K UHD (3840x2160), delta E < 2, couverture 99% Adobe RGB. Port USB-C avec Power Delivery. Support VESA. Idéal montage/photo.', 'https://images.unsplash.com/photo-1484480974693-6ca0a78fb36b?w=500&h=500&fit=crop', 699.99, 1, 7],
    ['Logitech Brio 4K', 'Webcam 4K Ultra HD 1080p60fps, autofocus avancé, correction auto-éclairage. Microphone intégré à réduction de bruit. Champ vision 90°. RightLight 3 avec HDR. Compatible tous les OS.', 'https://images.unsplash.com/photo-1612198188060-c7c2a3b66eae?w=500&h=500&fit=crop', 199.99, 1, 22],

    // Mode & Vêtements (7)
    ['Veste Cuir Noir Premium', 'Veste en cuir véritable nappa noir, doublure en soie italienne, coupe cintrée moderne. Détails: poches intérieures zippées, fermeture YKK premium, ceinture ajustable. Tailles XS à XXL. Épaisseur 1.5mm.', 'https://images.unsplash.com/photo-1551028719-00167b16ebc5?w=500&h=500&fit=crop', 499.99, 2, 9],
    ['Jeans Slim Bleu Délavé', 'Jeans premium coton stretch (98% coton, 2% élasthane), coupe slim moderne, teinture indigo naturelle. Rivets renforcés. Tailles 26-42. Couture française. Design intemporel.', 'https://images.unsplash.com/photo-1582889385099-0a74c10fe607?w=500&h=500&fit=crop', 129.99, 2, 35],
    ['Chemise Oxford Blanche', 'Chemise classique en coton oxford 100%, col button-down, double couture renforcée. Manches longues ajustables. Lavable machine. Coupe slim & regular. Tailles S-3XL.', 'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?w=500&h=500&fit=crop', 89.99, 2, 45],
    ['T-Shirt Col V Premium', 'T-shirt premium en coton peigné 100%, col V profond, finitions surjetées. Grammage 180g/m². Couleurs solides et imprimés géométriques. Tailles XS-3XL. Idéal casual & semi-formel.', 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&h=500&fit=crop', 39.99, 2, 80],
    ['Pull Laine Mérinos Gris', 'Pull en laine mérinos fine 100%, tricoté serré, thermorégulant naturel. Col rond. Poignets côtelés. Idéal automne/hiver. Non-piquant, hypoallergénique. Tailles XS-XL.', 'https://images.unsplash.com/photo-1591195853828-11db59a44f6b?w=500&h=500&fit=crop', 159.99, 2, 20],
    ['Sneakers Blanches Design', 'Baskets minimalistes cuir blanc premium avec détails gris. Semelle épaisse confortable EVA. Lacets contrastants. Design épuré. Tailles 36-46. Légères (290g pair).', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop', 149.99, 2, 40],
    ['Ceinture Cuir Noir Premium', 'Ceinture en cuir noir premium boucle acier brossé. Largeur 3.5cm. Coutures renforcées. Tailles 75cm-130cm. Design intemporel classique.', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop', 69.99, 2, 50],

    // Livres (6)
    ['Clean Code - Robert Martin', 'Guide essentiel pour écrire du code lisible, maintenable et scalable. Analyse détaillée de 10+ cas réels. Exercices pratiques inclus. 464 pages. Édition 2008. Référence industrie.', 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&h=500&fit=crop', 49.99, 3, 18],
    ['The Pragmatic Programmer', 'Conseils et astuces pour devenir un développeur plus productif. 352 pages. Édition révisée 2019. Couvre DevOps, design patterns, architecture. Écrit par Hunt & Thomas.', 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&h=500&fit=crop', 54.99, 3, 22],
    ['Design Patterns - Gang of Four', 'La bible des patterns de conception. 395 pages. Explique 23 patterns essentiels avec exemples C++ & Java. Diagrammes UML détaillés. Incontournable pour architectes logiciels.', 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=500&h=500&fit=crop', 64.99, 3, 12],
    ['Atomic Habits - James Clear', 'Construire meilleures habitudes et briser les mauvaises. Psychologie comportementale appliquée. 480 pages. Bestseller international. Exercices quotidiens. Science-based.', 'https://images.unsplash.com/photo-1507842217343-583f7270bfba?w=500&h=500&fit=crop', 28.99, 3, 35],
    ['Zero to One - Peter Thiel', 'Créer l\'avenir en partant de zéro. Stratégie startup & innovation. 506 pages. Fondateur PayPal. Lessons de 20 ans entrepreneuriat. Édition 2014.', 'https://images.unsplash.com/photo-1507842217343-583f7270bfba?w=500&h=500&fit=crop', 35.99, 3, 25],
    ['Python for Data Science', 'Maîtriser pandas, numpy, scikit-learn. 450 pages. Jupyter notebooks inclus. Data visualization avancée. Machine Learning fondamentals. Python 3.10+.', 'https://images.unsplash.com/photo-1507842217343-583f7270bfba?w=500&h=500&fit=crop', 59.99, 3, 16],

    // Maison & Décor (6)
    ['Lampe de Bureau LED Ajustable', 'Lampe LED premium avec 5 modes luminosité, température couleur ajustable 3000K-6500K. Bras flexible 360°. Batterie rechargeable USB. Port USB intégré pour charger téléphone. Consommation 5W.', 'https://images.unsplash.com/photo-1565636192335-14c46fa1120d?w=500&h=500&fit=crop', 79.99, 4, 28],
    ['Plante Monstera Artificielle', 'Plante artificielle haut de gamme réalisme extrême 120cm hauteur. Feuilles silicone détaillées. Pot céramique blanc mat inclus. Anti-UV pour extérieur. Entretien zéro.', 'https://images.unsplash.com/photo-1530836369250-ef72a3f5cda8?w=500&h=500&fit=crop', 89.99, 4, 15],
    ['Miroir Mural Doré Octagonal', 'Miroir décoratif design octagonal cadre métal doré brossé. Diamètre 80cm. Verre miroir haute réflexion. Installation murale simple. Design art déco moderne.', 'https://images.unsplash.com/photo-1578749556568-bc2c40e68b61?w=500&h=500&fit=crop', 199.99, 4, 8],
    ['Chaise Ergonomique Gamer', 'Chaise bureau gaming avec appui-tête réglable, support lombaire. Matière respirante mesh. Hauteur assise 45-55cm. Accoudoirs ajustables 3D. Base renforcée 160kg. Roulettes silencieuses.', 'https://images.unsplash.com/photo-1611947391424-3a7fb3585b03?w=500&h=500&fit=crop', 349.99, 4, 6],
    ['Étagères Flottantes Design', 'Set 3 étagères flottantes chêne massif avec support acier noir. Dimensions 80x25x15cm. Support 25kg charge max/étagère. Installation murale incluse. Design minimaliste scandinave.', 'https://images.unsplash.com/photo-1565636192335-14c46fa1120d?w=500&h=500&fit=crop', 149.99, 4, 12],
    ['Tapis Persan Premium', 'Tapis persan authentique 200x300cm laine 100% teint naturel. Motifs géométriques traditionnels. Noeuds 200/m². Épaisseur 8mm. Résistant usure. Teinture fixée.', 'https://images.unsplash.com/photo-1526749779700-7ee33bc25e94?w=500&h=500&fit=crop', 599.99, 4, 3],

    // Sports & Fitness (6)
    ['Vélo Gravel Premium', 'Vélo gravel cadre carbone 56cm, groupe Shimano GRX 11v, roues 700c, suspension avant 50mm. Poids 8.5kg. Freins hydrauliques. Capacité bagages 100kg. Setup tout terrain & route.', 'https://images.unsplash.com/photo-1532171875881-1e700285e7c0?w=500&h=500&fit=crop', 1899.99, 5, 4],
    ['Haltères Ajustables 40kg', 'Paire d\'haltères réglables 2x20kg avec support. Plaques fonte recouverte caoutchouc. Ergonomique. Increment 2kg. Idéal home gym. Garantie 2 ans.', 'https://images.unsplash.com/photo-1534438327276-14e5300c3a48?w=500&h=500&fit=crop', 279.99, 5, 10],
    ['Tapis de Yoga Premium', 'Tapis de yoga non-toxique TPE 183x61x6mm, antidérapant double face. Léger 1.5kg. Excellent grip sec & humide. Avec sangle transport. Couleurs naturelles.', 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?w=500&h=500&fit=crop', 49.99, 5, 32],
    ['Montre Fitness Garmin', 'Montre connectée sport multi-sports, écran AMOLED 1.2", batterie 11 jours. Capteurs: GPS, cardiaque, oxymètre, baromètre. Étanche 100m. Notifications smartwatch complètes.', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&h=500&fit=crop', 349.99, 5, 14],
    ['Chaussures Trail Running', 'Chaussures trail haute performance semelle Vibram, amorti CUSHIONIT, tige respirante mesh renforcé. Lacets anti-déverrouillage. Tailles 36-46. Poids 280g pair.', 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&h=500&fit=crop', 179.99, 5, 26],
    ['Sac à Dos Trail 50L', 'Sac à dos rando 50L polyester 600D imperméable, suspension ajustable, ceinture de hanche rembourrée. Compartiment hydratation. Poches latérales. Poids vide 1.8kg. Montains proven.', 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=500&h=500&fit=crop', 149.99, 5, 18],
];

$stmt = $pdo->prepare("INSERT INTO products (name, description, image_url, price, category_id, stock) VALUES (?, ?, ?, ?, ?, ?)");
foreach ($products as $product) {
    $stmt->execute($product);
}
echo "  ✅ {" . count($products) . "} produits insérés\n";

// ==========================================
// 4. INSÉRER QUELQUES COMMANDES
// ==========================================
echo "📦 Insertion des commandes d'exemple...\n";

$orders = [
    [2, 679.98, 'delivered'],
    [3, 1299.99, 'shipped'],
    [4, 449.99, 'confirmed'],
    [5, 879.97, 'pending'],
    [6, 599.99, 'delivered'],
];

$stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, ?)");
foreach ($orders as $order) {
    $stmt->execute($order);
}
echo "  ✅ {" . count($orders) . "} commandes insérées\n";

// ==========================================
// 5. AFFICHER LES STATISTIQUES
// ==========================================
echo "\n═══════════════════════════════════════════════════════════════\n";
echo "              📊 STATISTIQUES DE LA BASE DE DONNÉES\n";
echo "═══════════════════════════════════════════════════════════════\n";

$stats = [
    'users' => 'Utilisateurs',
    'categories' => 'Catégories',
    'products' => 'Produits',
    'orders' => 'Commandes',
];

foreach ($stats as $table => $label) {
    try {
        $result = $pdo->query("SELECT COUNT(*) as count FROM $table");
        $count = $result->fetch()['count'];
        printf("%-30s: %d\n", $label, $count);
    } catch (Exception $e) {
        printf("%-30s: Erreur\n", $label);
    }
}

echo "\n─────────────────────────────────────────────────────────────\n";
echo "Produits par catégorie:\n";
echo "─────────────────────────────────────────────────────────────\n";

try {
    $result = $pdo->query("
        SELECT c.name, COUNT(p.id) as count 
        FROM categories c 
        LEFT JOIN products p ON c.id = p.category_id 
        GROUP BY c.id, c.name 
        ORDER BY count DESC
    ");

    foreach ($result->fetchAll() as $row) {
        printf("  • %-35s: %d produits\n", $row['name'], $row['count']);
    }
} catch (Exception $e) {
    echo "  Erreur lors de la récupération des statistiques\n";
}

echo "\n═══════════════════════════════════════════════════════════════\n";
echo "✨ Les données premium ont été importées avec succès!\n";
echo "✨ Votre boutique NovaShop est prête à fonctionner.\n";
echo "═══════════════════════════════════════════════════════════════\n\n";

// Afficher les identifiants de connexion
echo "📝 Identifiants de connexion:\n";
echo "─────────────────────────────────────────────────────────────\n";
echo "Admin:\n";
echo "  Email: admin@novashop.local\n";
echo "  Mot de passe: admin123\n\n";
echo "Clients d'exemple:\n";
echo "  • marie.durand@email.com\n";
echo "  • jean.leclerc@email.com\n";
echo "  • sophie.bernard@email.com\n";
echo "  • thomas.petit@email.com\n";
echo "  • isabelle.renard@email.com\n";
echo "\nMot de passe tous les clients: password123\n";
echo "═════════════════════════════════════════════════════════════════\n";

echo "\n✅ Importation terminée avec succès!\n";
?>
