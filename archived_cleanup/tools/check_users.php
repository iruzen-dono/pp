<?php
require_once __DIR__ . '/../App/Config/Database.php';
use App\Config\Database;

try {
    $pdo = Database::getConnection();
    $stmt = $pdo->query('SELECT COUNT(*) AS c FROM users');
    $count = $stmt->fetchColumn();
    echo "users_count:" . ($count ?? 0) . PHP_EOL;
} catch (Exception $e) {
    echo "ERR: " . $e->getMessage() . PHP_EOL;
}
