<?php
header('Content-Type: text/plain; charset=utf-8');

// Réduction du test
echo "TEST MINIMUM REPRODUCTION\n";
echo "==========================\n\n";

// Autoload
spl_autoload_register(function ($class) {
    $class = str_replace('\\', '/', $class);
    $file = __DIR__ . '/../' . $class . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

try {
    require_once __DIR__ . '/../App/Config/Database.php';
    
    // Forcer les erreurs
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
    
    echo "Obtention de la connexion...\n";
    $db = \App\Config\Database::getConnection();
    echo "✅ Connexion obtenue\n";
    
    echo "\nTest SELECT COUNT:\n";
    try {
        $stmt = $db->query("SELECT COUNT(*) as cnt FROM products");
        var_dump($stmt);
        $result = $stmt->fetchColumn();
        echo "Résultat: " . $result . "\n";
    } catch (Exception $e) {
        echo "❌ Erreur: " . $e->getMessage() . "\n";
        throw $e;
    }
    
    echo "\nTest SELECT *:\n";
    try {
        $stmt = $db->prepare("SELECT * FROM products LIMIT 1");
        $stmt->execute();
        var_dump($stmt);
        $result = $stmt->fetchAll();
        echo "Résultat: " . count($result) . " lignes\n";
    } catch (Exception $e) {
        echo "❌ Erreur: " . $e->getMessage() . "\n";
        throw $e;
    }
    
} catch (Exception $e) {
    echo "\n❌ EXCEPTION GLOBALE:\n";
    echo "Message: " . $e->getMessage() . "\n";
    echo "Code: " . $e->getCode() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
