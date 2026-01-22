<?php
// scripts/db_inspect.php
require_once __DIR__ . '/../App/Config/Database.php';

use App\Config\Database;

try {
    $pdo = Database::getConnection();
} catch (Throwable $e) {
    echo "ERROR: Could not connect to DB: " . $e->getMessage() . "\n";
    exit(1);
}

echo "Database: " . ($pdo->query('select database()')->fetchColumn()) . "\n\n";

// list tables
$stmt = $pdo->query("SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = DATABASE();");
$tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
if (!$tables) {
    echo "No tables found.\n";
    exit(0);
}

echo "Tables and row counts:\n";
foreach ($tables as $t) {
    try {
        $c = $pdo->query("SELECT COUNT(*) FROM `" . str_replace('`','``',$t) . "`")->fetchColumn();
    } catch (Throwable $e) {
        $c = 'error';
    }
    echo str_pad($t, 20) . " : " . $c . "\n";
}

// show sample rows for key tables
$keyTables = ['users','products','categories','orders','order_items'];
foreach ($keyTables as $kt) {
    if (in_array($kt,$tables)) {
        echo "\n--- Sample rows from {$kt} ---\n";
        $rows = $pdo->query("SELECT * FROM `" . $kt . "` LIMIT 5")->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $r) {
            echo json_encode($r, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) . "\n";
        }
    }
}

exit(0);
