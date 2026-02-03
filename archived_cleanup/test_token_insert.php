<?php
require 'App/Config/Database.php';
use App\Config\Database;

echo "╔═══════════════════════════════════════════════╗\n";
echo "║   TEST D'INSERTION DE TOKEN                   ║\n";
echo "╚═══════════════════════════════════════════════╝\n\n";

try {
    $pdo = Database::getConnection();
    
    // Vérifier la structure de la table
    echo "1️⃣  Vérification de la structure de la table:\n";
    $stmt = $pdo->query("DESCRIBE email_verification_tokens");
    $columns = $stmt->fetchAll();
    
    foreach ($columns as $col) {
        echo "   - {$col['Field']}: {$col['Type']}\n";
    }
    
    // Tester l'insertion directe
    echo "\n2️⃣  Test d'insertion directe:\n";
    
    $token = bin2hex(random_bytes(32));
    $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
    $userId = 3; // Zhou Jules
    
    echo "   Token: $token\n";
    echo "   User ID: $userId\n";
    echo "   Expires: $expiresAt\n\n";
    
    $stmt = $pdo->prepare("
        INSERT INTO email_verification_tokens (user_id, token, expires_at) 
        VALUES (?, ?, ?)
    ");
    
    $result = $stmt->execute([$userId, $token, $expiresAt]);
    
    if ($result) {
        echo "   ✅ Insertion réussie!\n";
        
        // Vérifier que c'est bien en BD
        $stmt = $pdo->prepare("SELECT * FROM email_verification_tokens WHERE token = ?");
        $stmt->execute([$token]);
        $check = $stmt->fetch();
        
        if ($check) {
            echo "   ✅ Confirmation: Token retrouvé en BD\n";
        } else {
            echo "   ❌ PROBLÈME: Token n'est pas retrouvé!\n";
        }
    } else {
        echo "   ❌ Insertion échouée!\n";
        $errors = $stmt->errorInfo();
        echo "   Erreur SQL: {$errors[2]}\n";
    }
    
} catch (\Exception $e) {
    echo "❌ Exception: " . $e->getMessage() . "\n";
}
?>
