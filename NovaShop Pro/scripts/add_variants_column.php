<?php
require_once __DIR__ . '/../App/Config/Database.php';

echo "Checking products table for column variants...\n";

try {
    $pdo = \App\Config\Database::getConnection();

    $stmt = $pdo->prepare("SELECT COUNT(*) as cnt FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'products' AND COLUMN_NAME = 'variants'");
    $stmt->execute();
    $cnt = (int) $stmt->fetchColumn();

    if ($cnt > 0) {
        echo "Column variants already exists. Nothing to do.\n";
        exit(0);
    }

    echo "Column missing — attempting to add it...\n";

    // Use TEXT to match setup.sql; default to empty string
    $sql = "ALTER TABLE `products` ADD COLUMN `variants` TEXT DEFAULT ''";
    $pdo->exec($sql);

    echo "Column variants added successfully.\n";
    exit(0);
} catch (Throwable $e) {
    echo "Error while adding column: " . $e->getMessage() . "\n";
    exit(1);
}
