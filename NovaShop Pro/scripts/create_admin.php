<?php
// scripts/create_admin.php
// Usage: php scripts/create_admin.php

require_once __DIR__ . '/../App/Config/Database.php';

use App\Config\Database;

try {
    $pdo = Database::getConnection();
} catch (Throwable $e) {
    echo "ERROR: DB connection failed: " . $e->getMessage() . "\n";
    exit(1);
}

$email = 'admin@novashop.local';
$password = 'admin123';
$name = 'Admin User';
$role = 'admin';
$hashed = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $pdo->prepare('SELECT id FROM users WHERE email = :email');
    $stmt->execute(['email' => $email]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $id = $row['id'];
        $u = $pdo->prepare('UPDATE users SET name = :name, password = :password, role = :role WHERE id = :id');
        $u->execute(['name' => $name, 'password' => $hashed, 'role' => $role, 'id' => $id]);
        echo "Admin user updated (id={$id}).\n";
    } else {
        $i = $pdo->prepare('INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)');
        $i->execute(['name' => $name, 'email' => $email, 'password' => $hashed, 'role' => $role]);
        echo "Admin user created (email={$email}).\n";
    }
    echo "Credentials: {$email} / {$password}\n";
} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage() . "\n";
    exit(2);
}

exit(0);
