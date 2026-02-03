<?php
/**
 * Archived copy of start_novashop.php (moved out of project root for safety)
 *
 * NOTE: This file was moved from the project root to avoid accidental execution.
 * Keep it as an archive only. To re-enable, review and move back intentionally.
 */

set_time_limit(300);
ini_set('display_errors', 1);

echo "\n";
echo "╔════════════════════════════════════════════════════════════╗\n";
echo "║           🚀 NovaShop Pro - Démarrage Automatique         ║\n";
echo "╚════════════════════════════════════════════════════════════╝\n\n";

// Configuration - Lire depuis les variables d'environnement ou utiliser les valeurs par défaut
$dbHost = getenv('DB_HOST') ?: 'localhost';
$dbUser = getenv('DB_USER') ?: 'root';
$dbPass = getenv('DB_PASS') ?: '0000';
$dbName = 'novashop';

// Étape 1: Créer les images locales
echo "📸 ÉTAPE 1: Création des images produits...\n";
echo str_repeat('─', 60) . "\n";

$imagesDir = __DIR__ . '/../Public/Assets/Images/products';

if (!is_dir($imagesDir)) {
	@mkdir($imagesDir, 0755, true);
	echo "   ✅ Dossier images créé\n";
}

// Créer les 35 images PNG
$imageNames = [
	'macbook_pro.png', 'wireless_headphones.png', 'iphone_camera.png',
	'smartwatch.png', 'mechanical_keyboard.png', 'gaming_mouse.png',
	'usb_hub.png', 'portable_charger.png', 'monitor_gaming.png', 'tablet.png',
	'leather_jacket.png', 'designer_watch.png', 'classic_jeans.png',
	'dress_elegant.png', 'sneakers_premium.png', 'sunglasses_style.png', 'scarf_silk.png',
	'design_patterns.png', 'clean_code.png', 'javascript_book.png',
	'web_development.png', 'psychology_book.png', 'business_strategy.png',
	'persian_rug.png', 'modern_lamp.png', 'designer_chair.png',
	'table_marble.png', 'wooden_shelves.png', 'decorative_mirror.png',
	'gravel_bike.png', 'tennis_racket.png', 'yoga_mat.png',
	'dumbbells_set.png', 'running_shoes.png', 'football_ball.png'
];

$pngData = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg==');

$created = 0;
foreach ($imageNames as $imageName) {
	$filepath = $imagesDir . '/' . $imageName;
	if (!file_exists($filepath)) {
		file_put_contents($filepath, $pngData);
		$created++;
	}
}

echo "   ✅ " . count($imageNames) . " images prêtes\n\n";

// Étape 2: Connexion à la base de données
echo "🗄️  ÉTAPE 2: Initialisation de la base de données...\n";
echo str_repeat('─', 60) . "\n";

try {
	// Connexion pour vérifier le serveur
	$pdo = new PDO("mysql:host=$dbHost", $dbUser, $dbPass);
	echo "   ✅ Connexion MySQL réussie\n";
    
	// Supprimer et recréer la base
	$pdo->exec("DROP DATABASE IF EXISTS $dbName");
	$pdo->exec("CREATE DATABASE $dbName CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
	echo "   ✅ Base de données créée\n";
    
	// Utiliser la nouvelle base
	$pdo = new PDO("mysql:host=$dbHost;dbname=$dbName;charset=utf8mb4", $dbUser, $dbPass);
    
} catch (PDOException $e) {
	echo "   ❌ Erreur de connexion: " . $e->getMessage() . "\n";
	echo "   💡 Assurez-vous que MySQL/MariaDB est lancé!\n";
	echo "   💡 Credentials: $dbUser / $dbPass sur $dbHost\n\n";
	exit(1);
}

// NOTE: Remaining logic omitted in archive for brevity. See original file before use.

echo "\nArchive created. Do not run without review.\n";

?>
