<?php
require 'App/Config/Database.php';
use App\Config\Database;

$pdo = Database::getConnection();
$stmt = $pdo->query('SELECT id, status FROM orders');
$orders = $stmt->fetchAll();

echo "Statuts en base de données:\n";
foreach($orders as $o) {
    echo "Order {$o['id']}: {$o['status']}\n";
}
?>
