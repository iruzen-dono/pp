<?php
header('Content-Type: text/plain; charset=utf-8');

echo "TEST SINGLETON DATABASE\n";
echo "=======================\n\n";

// Autoload
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Test 1: Appels multiples
echo "TEST 1 - Appels multiples à getConnection():\n";
$db1 = \App\Config\Database::getConnection();
$db2 = \App\Config\Database::getConnection();
$db3 = \App\Config\Database::getConnection();

echo "db1 === db2: " . ($db1 === $db2 ? "OUI (singleton)" : "NON") . "\n";
echo "db2 === db3: " . ($db2 === $db3 ? "OUI (singleton)" : "NON") . "\n";

// Test 2: Tester avec chaque instance
echo "\nTEST 2 - Requête avec chaque instance:\n";

// Créer une nouvelle instance sans Singleton
echo "\nCréation manuelle de PDO:\n";
$pdoManual = new PDO(
    'mysql:host=localhost;dbname=novashop_db;charset=utf8mb4',
    'root',
    '0000',
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
);

$stmt = $pdoManual->query("SELECT COUNT(*) FROM products");
$count = $stmt->fetchColumn();
echo "Résultat PDO manuel: " . $count . "\n";

// Avec la classe Database
echo "\nVia classe Database:\n";
$db = \App\Config\Database::getConnection();
echo "Type de \$db: " . get_class($db) . "\n";

// Essayer de voir l'état interne
$reflection = new ReflectionClass('\App\Config\Database');
$property = $reflection->getProperty('instance');
$property->setAccessible(true);
$instance = $property->getValue();

echo "Instance interne: " . (is_null($instance) ? "NULL" : get_class($instance)) . "\n";

// Essayer une requête
$stmt = $db->query("SELECT COUNT(*) FROM products");
$count = $stmt->fetchColumn();
echo "Résultat: " . $count . "\n";
