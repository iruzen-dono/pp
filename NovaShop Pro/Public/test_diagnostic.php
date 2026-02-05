<?php
header('Content-Type: text/plain; charset=utf-8');

echo "DIAGNOSTIC DÉTAILLÉ DU PROBLÈME\n";
echo "================================\n\n";

// Test avec sql_mode
$pdo = new PDO(
    'mysql:host=localhost;dbname=novashop_db;charset=utf8mb4',
    'root',
    '0000',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
    ]
);

echo "AVANT sql_mode:\n";
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
echo "Résultat: " . count($stmt->fetchAll(PDO::FETCH_ASSOC)) . " produits\n";

echo "\nAPRÈS sql_mode:\n";
$pdo->exec(
    "SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'"
);

$stmt = $pdo->prepare("SELECT * FROM products");
echo "Préparation: OK\n";
$stmt->execute();
echo "Exécution: OK\n";
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "fetchAll: " . count($result) . " produits\n";

// Vérifier l'état du cursor
echo "\nDiagnostic du PDOStatement:\n";
echo "rowCount: " . $stmt->rowCount() . "\n";

// Refaire la requête
echo "\nREFAIRE LA REQUÊTE:\n";
$stmt2 = $pdo->prepare("SELECT * FROM products");
$stmt2->execute();
$result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
echo "Résultat: " . count($result2) . " produits\n";

// Vérifier s'il y a un problème de mode fetch
echo "\nTESTER FETCH_ASSOC UNIQUEMENT:\n";
$stmt3 = $pdo->prepare("SELECT COUNT(*) as cnt FROM products");
$stmt3->execute();
$row = $stmt3->fetch(PDO::FETCH_ASSOC);
echo "Count: " . $row['cnt'] . "\n";
