<?php
// scripts/import_sql.php
// Usage: php scripts/import_sql.php

require_once __DIR__ . '/../App/Config/Database.php';

use App\Config\Database;

// Bootstrap: ensure autoload-ish
spl_autoload_register(function ($class) {
    $path = __DIR__ . '/../' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($path)) {
        require_once $path;
    }
});

echo "Import SQL script starting...\n";

$sqlFile = __DIR__ . '/../setup.sql';
if (!file_exists($sqlFile)) {
    echo "ERROR: setup.sql not found at $sqlFile\n";
    exit(1);
}

try {
    $pdo = Database::getConnection();
} catch (Throwable $e) {
    echo "ERROR: Could not connect to DB: " . $e->getMessage() . "\n";
    exit(1);
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    echo "ERROR: Could not read setup.sql\n";
    exit(1);
}

// Remove Windows CR to normalize
$sql = str_replace("\r\n", "\n", $sql);

// Try executing full file first
try {
    $pdo->exec($sql);
    echo "Executed entire SQL file successfully.\n";
    exit(0);
} catch (PDOException $e) {
    echo "Full exec failed: " . $e->getMessage() . "\n";
    echo "Falling back to executing individual statements...\n";
}

// Fallback: split by semicolon safely (naive)
$statements = preg_split('/;\s*\n/', $sql);
$success = 0;
$failed = 0;
foreach ($statements as $stmt) {
    $stmt = trim($stmt);
    if ($stmt === '' || strpos($stmt, 'DELIMITER') !== false) continue;
    try {
        $pdo->exec($stmt);
        $success++;
    } catch (PDOException $e) {
        $failed++;
        echo "Statement failed: " . substr($stmt,0,120) . "... => " . $e->getMessage() . "\n";
    }
}

echo "Import finished. Success: $success. Failed: $failed.\n";
if ($failed > 0) exit(2);
exit(0);
