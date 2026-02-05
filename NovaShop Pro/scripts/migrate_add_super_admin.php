<?php
require_once dirname(__DIR__) . '/App/Config/Database.php';

$db = \App\Config\Database::getConnection();

echo "=== Migration: Ajouter 'super_admin' à l'enum role ===\n\n";

try {
    // Modify the role column to add super_admin to the enum
    $sql = "ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin', 'super_admin') DEFAULT 'user'";
    $db->exec($sql);
    
    echo "✅ Colonne 'role' mise à jour avec succès!\n";
    echo "Nouvelles valeurs possibles: user, admin, super_admin\n";
    
} catch (PDOException $e) {
    echo "❌ Erreur lors de la migration:\n";
    echo $e->getMessage() . "\n";
    exit(1);
}
?>
