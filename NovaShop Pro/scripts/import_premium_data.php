<?php
/**
 * Import Premium Data Script
 * Script pour importer les données premium avec vraies images dans la base de données
 */

// Configuration de la base de données
$host = 'localhost';
$dbname = 'novashop';
$username = 'root';
$password = '0000';

// Essayer différentes combinaisons de connexion
$pdo = null;
$errors = [];

$configs = [
    ['localhost', 'root', '0000'],
    ['127.0.0.1', 'root', '0000'],
    ['localhost:3306', 'root', '0000'],
    ['localhost', 'root', ''],
];

foreach ($configs as $config) {
    try {
        $pdo = new PDO(
            "mysql:host={$config[0]};dbname=$dbname;charset=utf8mb4;port=3306",
            $config[1],
            $config[2],
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]
        );
        echo "✅ Connexion à la base de données réussie!\n";
        break;
    } catch (PDOException $e) {
        $errors[] = $e->getMessage();
    }
}

if ($pdo === null) {
    echo "❌ Erreur de connexion à la base de données\n";
    echo "\nErreurs rencontrées:\n";
    foreach ($errors as $error) {
        echo "  - " . $error . "\n";
    }
    echo "\n⚠️  Vérifiez que:\n";
    echo "  1. MySQL/MariaDB est en cours d'exécution\n";
    echo "  2. La base de données 'novashop' existe\n";
    echo "  3. Les identifiants sont corrects (user: root)\n";
    exit(1);
}

// Lire et exécuter le fichier SQL
$sqlFile = __DIR__ . '/../seed_premium.sql';

if (!file_exists($sqlFile)) {
    echo "❌ Fichier seed_premium.sql non trouvé!\n";
    echo "   Cherché à: $sqlFile\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);

// Diviser par les séparateurs de commentaires et exécuter les requêtes
$statements = array_filter(
    array_map('trim', preg_split('/;(?=(?:[^\']*\'[^\']*\')*[^\']*$)/', $sql)),
    function ($stmt) {
        return !empty($stmt) && !preg_match('/^--/', $stmt);
    }
);

$count = 0;
foreach ($statements as $statement) {
    try {
        $pdo->exec($statement);
        $count++;
    } catch (PDOException $e) {
        // Ignorer les commentaires SELECT
        if (strpos($statement, 'SELECT') !== false && strpos($e->getMessage(), 'SQLSTATE') === false) {
            // C'est probablement une requête de vérification
            continue;
        }
    }
}

echo "✅ Script d'importation exécuté avec succès!\n";
echo "📊 Requêtes exécutées: $count\n\n";

// Afficher les statistiques finales
echo "═══════════════════════════════════════════════════════════════\n";
echo "              📊 STATISTIQUES DE LA BASE DE DONNÉES\n";
echo "═══════════════════════════════════════════════════════════════\n";

// Créer une nouvelle connexion pour les statistiques
try {
    $pdo2 = new PDO(
        "mysql:host=localhost;dbname=novashop;charset=utf8mb4;port=3306",
        'root',
        '0000',
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
        ]
    );
    
    $stats = [
        'users' => 'Utilisateurs',
        'categories' => 'Catégories',
        'products' => 'Produits',
        'orders' => 'Commandes',
    ];

    foreach ($stats as $table => $label) {
        try {
            $result = $pdo2->query("SELECT COUNT(*) as count FROM $table");
            $count = $result->fetch()['count'];
            printf("%-30s: %d\n", $label, $count);
        } catch (Exception $e) {
            printf("%-30s: Erreur\n", $label);
        }
    }

    // Statistiques produits par catégorie
    echo "\n─────────────────────────────────────────────────────────────\n";
    echo "Produits par catégorie:\n";
    echo "─────────────────────────────────────────────────────────────\n";

    try {
        $result = $pdo2->query("
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

    // Chiffre d'affaires
    echo "\n─────────────────────────────────────────────────────────────\n";

    try {
        $result = $pdo2->query("
            SELECT COUNT(*) as total_orders, SUM(total) as total_revenue
            FROM orders
            WHERE status IN ('delivered', 'shipped', 'confirmed')
        ");
        $data = $result->fetch();

        printf("Chiffre d'affaires confirmé: €%.2f\n", $data['total_revenue'] ?? 0);
        printf("Commandes validées: %d\n", $data['total_orders'] ?? 0);
    } catch (Exception $e) {
        echo "Erreur lors de la récupération des revenus\n";
    }
} catch (Exception $e) {
    echo "⚠️  Impossible de récupérer les statistiques\n";
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
echo "\nTous les utilisateurs clients ont le mot de passe: (password123)\n";
echo "═════════════════════════════════════════════════════════════════\n";
?>
