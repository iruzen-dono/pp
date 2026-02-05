<?php
require_once __DIR__ . '/../App/Config/Database.php';

echo "Checking users table for column email_verified_at...\n";
try {
    $pdo = App\Config\Database::getConnection();
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'users' AND COLUMN_NAME = 'email_verified_at'");
    $stmt->execute();
    $cnt = (int) $stmt->fetchColumn();
    if ($cnt > 0) {
        echo "Column email_verified_at already exists.\n";
        exit(0);
    }

    echo "Column missing — adding email_verified_at (DATETIME NULL)...\n";
    $pdo->exec("ALTER TABLE `users` ADD COLUMN `email_verified_at` DATETIME NULL");
    echo "Column email_verified_at added.\n";
    exit(0);
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
    exit(1);
}
