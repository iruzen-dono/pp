<?php
require_once __DIR__ . '/App/Config/Database.php';

use App\Config\Database;

// Lire le fichier SQL
$sqlFile = __DIR__ . '/migrate_password_resets.sql';
if (!file_exists($sqlFile)) {
    echo "Migration SQL non trouvée: $sqlFile\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    echo "Impossible de lire le fichier SQL.\n";
    exit(1);
}

try {
    $pdo = Database::getConnection();
    // Exécuter le SQL (contient CREATE TABLE)
    $pdo->exec($sql);
    echo "Migration exécutée avec succès. La table password_resets doit maintenant exister.\n";
} catch (\Exception $e) {
    echo "Erreur lors de l'exécution de la migration: " . $e->getMessage() . "\n";
    echo "Vérifiez les permissions DB et la configuration dans App/Config/env.php ou le fichier .env.\n";
    exit(1);
}
