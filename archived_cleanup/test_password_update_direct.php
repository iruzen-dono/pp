<?php
/**
 * Direct test: Update password in DB and verify it works
 * Usage: php test_password_update_direct.php <userId> <newPassword>
 */
require __DIR__ . '/App/Config/Database.php';
require __DIR__ . '/App/Core/Model.php';
require __DIR__ . '/App/Models/User.php';

use App\Config\Database;
use App\Models\User;

if (count($argv) < 3) {
    echo "Usage: php test_password_update_direct.php <userId> <newPassword>\n";
    echo "Example: php test_password_update_direct.php 7 TestPassword123\n";
    exit(1);
}

$userId = (int)$argv[1];
$newPassword = $argv[2];

try {
    $userModel = new User();
    
    // 1. Check user before update
    echo "[1] Fetching user $userId before update...\n";
    $userBefore = $userModel->findById($userId);
    if (!$userBefore) {
        echo "ERROR: User $userId not found\n";
        exit(1);
    }
    echo "  Email: " . $userBefore['email'] . "\n";
    echo "  Old hash: " . substr($userBefore['password'], 0, 30) . "...\n";
    
    // 2. Hash new password
    echo "\n[2] Hashing new password...\n";
    $newHash = password_hash($newPassword, PASSWORD_BCRYPT);
    echo "  New hash: " . substr($newHash, 0, 30) . "...\n";
    
    // 3. Update password in DB
    echo "\n[3] Updating password in DB...\n";
    $rowsAffected = $userModel->updatePassword($userId, $newHash);
    echo "  Rows affected: $rowsAffected\n";
    
    if ($rowsAffected === 0) {
        echo "  WARNING: No rows affected! Password may not have been updated.\n";
    }
    
    // 4. Verify update
    echo "\n[4] Fetching user after update...\n";
    $userAfter = $userModel->findById($userId);
    echo "  New hash in DB: " . substr($userAfter['password'], 0, 30) . "...\n";
    
    // 5. Test password verification
    echo "\n[5] Testing password_verify()...\n";
    $verifyResult = password_verify($newPassword, $userAfter['password']);
    echo "  password_verify('$newPassword', hash) = " . ($verifyResult ? 'TRUE ✓' : 'FALSE ✗') . "\n";
    
    if ($verifyResult) {
        echo "\n✓ SUCCESS: Password was updated and verifies correctly!\n";
    } else {
        echo "\n✗ FAILURE: Password does not verify. Hash mismatch?\n";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}
?>
