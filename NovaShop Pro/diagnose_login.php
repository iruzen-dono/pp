<?php
// Direct test of login functionality
session_start();

// Test 1: Check User model
echo "=== Testing User Model ===\n";
require_once 'App/Models/User.php';
$userModel = new \App\Models\User();

// Try to find an existing user
$user = $userModel->findByEmail('admin@novashop.com');
if ($user) {
    echo "✓ Admin user found\n";
    echo "  Email: " . $user['email'] . "\n";
    echo "  Email verified: " . ($user['email_verified_at'] ? 'Yes' : 'No') . "\n";
} else {
    echo "✗ Admin user NOT found\n";
    echo "  Available users in database:\n";
    
    // Try to get all users
    try {
        $allUsers = $userModel->getAll();
        if ($allUsers && count($allUsers) > 0) {
            foreach ($allUsers as $u) {
                echo "    - " . $u['email'] . " (verified: " . ($u['email_verified_at'] ? 'Yes' : 'No') . ")\n";
            }
        } else {
            echo "    No users found in database\n";
        }
    } catch (\Exception $e) {
        echo "    Error querying users: " . $e->getMessage() . "\n";
    }
}

// Test 2: Check CSRF middleware
echo "\n=== Testing CSRF Middleware ===\n";
require_once 'App/Middleware/CsrfMiddleware.php';
$token = \App\Middleware\CsrfMiddleware::generateToken();
echo "Generated token: " . substr($token, 0, 10) . "...\n";
echo "Token in session: " . (isset($_SESSION['csrf_token']) ? 'Yes' : 'No') . "\n";

// Test 3: Check controller
echo "\n=== Testing AuthController ===\n";
require_once 'App/Controllers/AuthController.php';
$controller = new \App\Controllers\AuthController();
echo "✓ AuthController instantiated\n";
?>
