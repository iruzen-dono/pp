<?php
// Test ultra-simple sans aucune classe
header('Content-Type: text/plain; charset=utf-8');

echo "TEST ULTRA-SIMPLE\n";
echo "=================\n\n";

// Connexion directe
$pdo = new PDO(
    'mysql:host=localhost;dbname=novashop_db;charset=utf8mb4',
    'root',
    '0000'
);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Test 1: SELECT COUNT
$r1 = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
echo "1. SELECT COUNT(*) FROM products: " . $r1 . "\n";

// Test 2: SELECT * LIMIT 1
$r2 = $pdo->query("SELECT * FROM products LIMIT 1")->fetch(PDO::FETCH_ASSOC);
echo "2. SELECT * LIMIT 1: ";
if ($r2) {
    echo "ID=" . $r2['id'] . ", Name=" . $r2['name'] . "\n";
} else {
    echo "Aucun résultat\n";
}

// Test 3: SHOW TABLES
$r3 = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
echo "3. SHOW TABLES: " . implode(", ", $r3) . "\n";

// Test 4: DESCRIBE products
$r4 = $pdo->query("DESCRIBE products")->fetchAll(PDO::FETCH_ASSOC);
echo "4. DESCRIBE products: " . count($r4) . " colonnes\n";
foreach (array_slice($r4, 0, 3) as $col) {
    echo "   - " . $col['Field'] . " (" . $col['Type'] . ")\n";
}

// Test 5: SELECT ALL with prepare
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();
$all = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo "5. SELECT * avec prepare/execute: " . count($all) . " lignes\n";

if (count($all) === 0) {
    echo "\n⚠️  PROBLÈME DÉTECTÉ: prepare/execute retourne 0 lignes!\n";
} else {
    echo "\n✅ Tout fonctionne correctement!\n";
}
