<?php
/**
 * Génère les vrais hashes bcrypt
 * À exécuter une seule fois pour obtenir les hashes réels
 */

$password1 = 'admin123';
$password2 = 'client123';

$hash1 = password_hash($password1, PASSWORD_BCRYPT, ['cost' => 10]);
$hash2 = password_hash($password2, PASSWORD_BCRYPT, ['cost' => 10]);

echo "╔══════════════════════════════════════════════════════════════╗\n";
echo "║            VRAIS HASHES BCRYPT - NOVASHOP PRO               ║\n";
echo "╚══════════════════════════════════════════════════════════════╝\n\n";

echo "1️⃣  ADMIN\n";
echo "   Mot de passe: $password1\n";
echo "   Hash: $hash1\n";
echo "   SQL: UPDATE users SET password = '$hash1' WHERE email = 'admin@novashop.local';\n\n";

echo "2️⃣  CLIENT\n";
echo "   Mot de passe: $password2\n";
echo "   Hash: $hash2\n";
echo "   SQL: UPDATE users SET password = '$hash2' WHERE email = 'client@novashop.local';\n\n";

// Vérification que les hashes fonctionnent
echo "✅ Vérification des hashes:\n";
echo "   Admin: " . (password_verify($password1, $hash1) ? "✓ OK" : "✗ ERREUR") . "\n";
echo "   Client: " . (password_verify($password2, $hash2) ? "✓ OK" : "✗ ERREUR") . "\n";

// Créer le SQL à injecter
$sqlUpdate = "USE novashop;\nUPDATE users SET password = '$hash1' WHERE email = 'admin@novashop.local';\nUPDATE users SET password = '$hash2' WHERE email = 'client@novashop.local';\nSELECT email, password FROM users WHERE email IN ('admin@novashop.local', 'client@novashop.local');";

file_put_contents(__DIR__ . '/../fix_passwords.sql', $sqlUpdate);
echo "\n📄 Fichier 'fix_passwords.sql' créé avec les mises à jour.\n";
?>
