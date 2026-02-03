<?php
header('Content-Type: text/plain; charset=utf-8');

echo "TEST PDO AVEC SQL_MODE\n";
echo "======================\n\n";

// Connexion 1: Sans sql_mode
echo "TEST 1 - Sans sql_mode:\n";
$pdo1 = new PDO(
    'mysql:host=localhost;dbname=novashop_db;charset=utf8mb4',
    'root',
    '0000',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ]
);

$stmt1 = $pdo1->prepare("SELECT * FROM products");
$stmt1->execute();
$result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
echo "Résultat: " . count($result1) . " produits\n";

// Connexion 2: Avec sql_mode
echo "\nTEST 2 - Avec sql_mode:\n";
$pdo2 = new PDO(
    'mysql:host=localhost;dbname=novashop_db;charset=utf8mb4',
    'root',
    '0000',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ]
);

$pdo2->exec(
    "SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'"
);

$stmt2 = $pdo2->prepare("SELECT * FROM products");
$stmt2->execute();
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
echo "Résultat: " . count($result2) . " produits\n";

// Connexion 3: Via la classe Database
echo "\nTEST 3 - Via classe Database:\n";
try {
    require_once __DIR__ . '/../App/Config/Database.php';
    $db = \App\Config\Database::getConnection();
    
    $stmt3 = $db->prepare("SELECT * FROM products");
    $stmt3->execute();
    $result3 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
    echo "Résultat: " . count($result3) . " produits\n";
} catch (Exception $e) {
    echo "Erreur: " . $e->getMessage() . "\n";
}

echo "\n";
echo "Vérifiez le sql_mode actuel:\n";
$check = new PDO('mysql:host=localhost;dbname=novashop_db;charset=utf8mb4', 'root', '0000');
$mode = $check->query("SELECT @@SESSION.sql_mode")->fetchColumn();
echo "sql_mode: " . $mode . "\n";
