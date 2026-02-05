<?php
/**
 * Script pour générer les vrais hashes bcrypt des mots de passe de test
 */

// Mots de passe de test
$passwords = [
    'admin123' => 'admin@novashop.local',
    'client123' => 'client@novashop.local'
];

echo "╔════════════════════════════════════════════════════════════════╗\n";
echo "║        GÉNÉRATEUR DE HASHES BCRYPT POUR NOVASHOP              ║\n";
echo "╚════════════════════════════════════════════════════════════════╝\n\n";

foreach ($passwords as $password => $email) {
    $hash = password_hash($password, PASSWORD_BCRYPT);
    echo "Email: $email\n";
    echo "Mot de passe: $password\n";
    echo "Hash: $hash\n";
    echo "SQL: UPDATE users SET password = '$hash' WHERE email = '$email';\n";
    echo str_repeat("-", 70) . "\n\n";
}

echo "✅ Copie les commandes SQL ci-dessus et exécute-les dans MariaDB !\n";
?>
