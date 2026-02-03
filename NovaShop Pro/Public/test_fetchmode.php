<?php
header('Content-Type: text/plain; charset=utf-8');

echo "TEST FETCH_MODE\n";
echo "===============\n\n";

// Connexion 1: SANS ATTR_DEFAULT_FETCH_MODE
echo "TEST 1 - SANS ATTR_DEFAULT_FETCH_MODE:\n";
$pdo1 = new PDO(
    'mysql:host=localhost;dbname=novashop_db;charset=utf8mb4',
    'root',
    '0000',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,  // COMMENTÉ
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ]
);

$pdo1->exec("SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");

$stmt = $pdo1->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Résultat: " . count($result) . " produits\n";

// Connexion 2: AVEC ATTR_DEFAULT_FETCH_MODE
echo "\nTEST 2 - AVEC ATTR_DEFAULT_FETCH_MODE:\n";
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

$pdo2->exec("SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");

$stmt = $pdo2->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Résultat: " . count($result) . " produits\n";

// Connexion 3: AVEC ATTR_DEFAULT_FETCH_MODE mais sans sql_mode
echo "\nTEST 3 - AVEC FETCH_MODE SANS SQL_MODE:\n";
$pdo3 = new PDO(
    'mysql:host=localhost;dbname=novashop_db;charset=utf8mb4',
    'root',
    '0000',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ]
);

// PAS DE sql_mode!

$stmt = $pdo3->prepare("SELECT * FROM products");
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Résultat: " . count($result) . " produits\n";

// Connexion 4: AVEC les deux
echo "\nTEST 4 - EXACTEMENT COMME DANS DATABASE.PHP:\n";
$pdo4 = new PDO(
    'mysql:host=localhost;dbname=novashop_db;charset=utf8mb4',
    'root',
    '0000',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ]
);

$pdo4->exec("SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");

$stmt = $pdo4->prepare("SELECT COUNT(*) FROM products");
echo "Avant execute: stmt type = " . get_class($stmt) . "\n";
$stmt->execute();
echo "Après execute\n";
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "Après fetchAll\n";
echo "Résultat: " . count($result) . " produits\n";
if ($result) {
    var_dump($result[0]);
}
