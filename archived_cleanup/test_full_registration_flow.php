<?php
/**
 * Script pour:
 * 1. Tester l'inscription d'un nouvel utilisateur
 * 2. Vérifier que le token est inséré en base
 * 3. Afficher un lien de vérification
 */

require_once 'App/Config/Database.php';
require_once 'App/Core/Model.php';
require_once 'App/Models/User.php';
require_once 'App/Models/EmailVerificationToken.php';

// Données de test
$testName = 'Test User ' . time();
$testEmail = 'testuser' . time() . '@localhost.test';
$testPassword = 'password123';

echo "=== TEST D'INSCRIPTION ET DE TOKEN ===\n\n";

echo "1. Données de test:\n";
echo "   - Nom: $testName\n";
echo "   - Email: $testEmail\n";
echo "   - Mot de passe: $testPassword\n\n";

try {
    $userModel = new \App\Models\User();
    $tokenModel = new \App\Models\EmailVerificationToken();
    
    // Étape 1: Vérifier que l'email n'existe pas
    if ($userModel->findByEmail($testEmail)) {
        echo "❌ L'email existe déjà (ne devrait pas arriver ici)\n";
        exit(1);
    }
    
    // Étape 2: Créer l'utilisateur
    echo "2. Créer l'utilisateur...\n";
    $hashedPassword = password_hash($testPassword, PASSWORD_BCRYPT);
    $userId = $userModel->create($testName, $testEmail, $hashedPassword);
    
    echo "   ✅ User créé avec ID: " . $userId . "\n";
    
    if ($userId <= 0) {
        echo "   ❌ ERREUR: User ID invalide: $userId\n";
        exit(1);
    }
    
    // Étape 3: Créer le token
    echo "\n3. Créer le token de vérification...\n";
    $token = $tokenModel->create($userId);
    echo "   ✅ Token généré: " . substr($token, 0, 20) . "...\n";
    
    // Étape 4: Vérifier que le token est en base
    echo "\n4. Vérifier que le token est en base...\n";
    $tokenData = $tokenModel->getByToken($token);
    
    if ($tokenData) {
        echo "   ✅ Token trouvé en base!\n";
        echo "   - user_id: " . $tokenData['user_id'] . "\n";
        echo "   - expires_at: " . $tokenData['expires_at'] . "\n";
    } else {
        echo "   ❌ Token NON TROUVÉ en base!\n";
        
        // Diagnostic
        echo "\n   📋 Diagnostic:\n";
        $db = \App\Config\Database::getConnection();
        $stmt = $db->query("SELECT COUNT(*) as total FROM email_verification_tokens");
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        echo "   - Total tokens en base: $count\n";
        
        $stmt = $db->prepare("SELECT * FROM email_verification_tokens WHERE user_id = ?");
        $stmt->execute([$userId]);
        $userTokens = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo "   - Tokens pour user_id=$userId: " . count($userTokens) . "\n";
        if ($userTokens) {
            foreach ($userTokens as $t) {
                echo "     • Token: " . substr($t['token'], 0, 15) . "... expires: " . $t['expires_at'] . "\n";
            }
        }
        exit(1);
    }
    
    // Étape 5: Créer le lien de vérification
    echo "\n5. Lien de vérification:\n";
    $verificationLink = "http://localhost:8000/verify-email?token=" . urlencode($token);
    echo "   $verificationLink\n";
    
    echo "\n✅ TEST RÉUSSI!\n";
    echo "\nMaintenant, clique sur le lien ci-dessus pour vérifier l'email.\n";
    
} catch (\Exception $e) {
    echo "❌ ERREUR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
    exit(1);
}
