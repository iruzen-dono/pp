<?php
// scripts/reset_and_import.php
// Usage: php scripts/reset_and_import.php

require_once __DIR__ . '/../App/Config/Database.php';

use App\Config\Database;

spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

echo "Reset + Import SQL starting...\n";

try {
    $pdo = Database::getConnection();
} catch (Throwable $e) {
    echo "ERROR: Could not connect to DB: " . $e->getMessage() . "\n";
    exit(1);
}

try {
    // Disable foreign key checks, drop all user tables
    $pdo->exec("SET FOREIGN_KEY_CHECKS=0;");
    $stmt = $pdo->query("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = DATABASE();");
    $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
    foreach ($tables as $t) {
        echo "Dropping table: $t\n";
        $pdo->exec("DROP TABLE IF EXISTS `" . str_replace('`','``',$t) . "`");
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS=1;");
    echo "All tables dropped.\n";
} catch (PDOException $e) {
    echo "ERROR while dropping tables: " . $e->getMessage() . "\n";
    exit(1);
}

$sqlFile = __DIR__ . '/../setup.sql';
if (!file_exists($sqlFile)) {
    echo "ERROR: setup.sql not found at $sqlFile\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    echo "ERROR: Could not read setup.sql\n";
    exit(1);
}

try {
    $pdo->exec($sql);
    echo "SQL imported successfully.\n";
    exit(0);
} catch (PDOException $e) {
    echo "Import failed: " . $e->getMessage() . "\n";
    exit(2);
}
