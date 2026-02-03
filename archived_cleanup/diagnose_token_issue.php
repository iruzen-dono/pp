<?php
// Vérifier directement en base de données

$config = require 'App/Config/env.php';

$dsn = "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']};charset=utf8mb4";
$pdo = new PDO($dsn, $config['DB_USER'], $config['DB_PASS']);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$token = 'c3ac186f187830046c8a3331830a85457d496f3589c66b6944b996408f96777e';

echo "=== DIAGNOSTIC TOKEN ISSUE ===\n\n";

echo "1. Chercher le token dans la BD:\n";
$stmt = $pdo->prepare("SELECT * FROM email_verification_tokens WHERE token = ?");
$stmt->execute([$token]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    echo "✅ TOKEN TROUVÉ:\n";
    print_r($result);
    
    echo "\n2. Vérifier l'expiration:\n";
    $expiresAt = new DateTime($result['expires_at']);
    $now = new DateTime();
    echo "Expire à: " . $result['expires_at'] . "\n";
    echo "Maintenant: " . $now->format('Y-m-d H:i:s') . "\n";
    
    if ($expiresAt < $now) {
        echo "❌ TOKEN EXPIRÉ!\n";
    } else {
        echo "✅ Token valide (pas expiré)\n";
    }
} else {
    echo "❌ TOKEN NON TROUVÉ EN BASE DE DONNÉES!\n";
    
    echo "\n2. Afficher les 5 derniers tokens:\n";
    $stmt = $pdo->query("SELECT * FROM email_verification_tokens ORDER BY created_at DESC LIMIT 5");
    $tokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if ($tokens) {
        echo "Tokens en base:\n";
        foreach ($tokens as $t) {
            echo "- user_id=" . $t['user_id'] . " | created=" . $t['created_at'] . " | expires=" . $t['expires_at'] . "\n";
            echo "  token: " . substr($t['token'], 0, 30) . "...\n";
        }
    } else {
        echo "⚠️ Aucun token en base!\n";
    }
}

echo "\n3. Afficher les 3 derniers utilisateurs:\n";
$stmt = $pdo->query("SELECT id, name, email, is_active, email_verified_at, created_at FROM users ORDER BY id DESC LIMIT 3");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $u) {
    echo "- ID=" . $u['id'] . " | " . $u['email'] . " | créé=" . $u['created_at'] . " | verified=" . ($u['email_verified_at'] ? 'OUI' : 'NON') . "\n";
}
