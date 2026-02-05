<?php
require_once __DIR__ . '/../App/Config/Database.php';

echo "Checking users table for column is_active...\n";

try {
    $pdo = \App\Config\Database::getConnection();

    $stmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'is_active'");
    $stmt->execute();
    $cnt = (int) $stmt->fetchColumn();

    if ($cnt > 0) {
        echo "Column is_active already exists. Nothing to do.\n";
        exit(0);
    }

    echo "Column missing — attempting to add it...\n";

    // Use TINYINT(1) for compatibility; default to 1 (active)
    $sql = "ALTER TABLE `users` ADD COLUMN `is_active` TINYINT(1) NOT NULL DEFAULT 1";
    $pdo->exec($sql);

    echo "Column is_active added successfully.\n";
    exit(0);
} catch (Throwable $e) {
    echo "Error while adding column: " . $e->getMessage() . "\n";
    exit(1);
}
