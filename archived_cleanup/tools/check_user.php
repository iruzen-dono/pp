<?php
$config = require __DIR__ . '/../App/Config/env.php';
try {
    $pdo = new PDO("mysql:host={$config['db_host']};dbname={$config['db_name']};charset=utf8mb4", $config['db_user'], $config['db_pass']);
    $stmt = $pdo->prepare('SELECT id,name,email,created_at FROM users WHERE email = ? LIMIT 1');
    $stmt->execute(['testuser@example.com']);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        echo "FOUND: " . json_encode($row) . PHP_EOL;
    } else {
        echo "NOT FOUND\n";
    }
} catch (Exception $e) {
    echo "ERR: " . $e->getMessage() . PHP_EOL;
}
