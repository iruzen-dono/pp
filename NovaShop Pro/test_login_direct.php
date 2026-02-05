<?php
/**
 * Test login functionality directly
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== Testing Login Flow (Direct) ===\n\n";

// Test 1: Check database connection
echo "[1] Checking database...\n";
try {
    require_once 'App/Core/Database.php';
    $db = \App\Core\Database::getInstance();
    $result = $db->query("SELECT COUNT(*) as total FROM users");
    $row = $result->fetch(\PDO::FETCH_ASSOC);
    echo "✓ Database connected. Users in DB: " . $row['total'] . "\n\n";
} catch (\Exception $e) {
    echo "✗ Database error: " . $e->getMessage() . "\n\n";
    exit;
}

// Test 2: Check test user exists
echo "[2] Checking test user...\n";
require_once 'App/Models/User.php';
$userModel = new \App\Models\User();
$user = $userModel->findByEmail('admin@novashop.local');
if ($user) {
    echo "✓ Test user found\n";
    echo "  - Email: " . $user['email'] . "\n";
    echo "  - Name: " . $user['name'] . "\n";
    echo "  - Email verified: " . ($user['email_verified_at'] ? 'YES' : 'NO') . "\n";
    echo "  - Active: " . ($user['is_active'] ? 'YES' : 'NO') . "\n\n";
    
    // Test 3: Verify password
    echo "[3] Testing password verification...\n";
    $testPassword = 'admin123';
    if (password_verify($testPassword, $user['password'])) {
        echo "✓ Password verification works\n";
        echo "  - Password 'admin123' verified against hash\n\n";
    } else {
        echo "✗ Password verification failed\n";
        echo "  - Password 'admin123' does NOT match stored hash\n\n";
    }
} else {
    echo "✗ Test user NOT found\n\n";
}

// Test 4: Test CSRF token generation
echo "[4] Testing CSRF token generation...\n";
session_start();
require_once 'App/Middleware/CsrfMiddleware.php';
$token = \App\Middleware\CsrfMiddleware::generateToken();
echo "✓ CSRF token generated: " . substr($token, 0, 10) . "...\n";
echo "  - Token length: " . strlen($token) . "\n";
echo "  - Session token: " . (isset($_SESSION['csrf_token']) ? 'YES' : 'NO') . "\n\n";

// Test 5: Simulate login
echo "[5] Simulating login process...\n";
$_POST['email'] = 'admin@novashop.local';
$_POST['password'] = 'admin123';
$_POST['_csrf'] = $token;
$_SERVER['REQUEST_METHOD'] = 'POST';

require_once 'App/Controllers/AuthController.php';
$controller = new \App\Controllers\AuthController();

// Capture output
ob_start();
try {
    $controller->login();
    $output = ob_get_clean();
    echo "✓ Login process executed\n";
    if (isset($_SESSION['user'])) {
        echo "✓ User session created!\n";
        echo "  - User ID: " . $_SESSION['user']['id'] . "\n";
        echo "  - User Email: " . $_SESSION['user']['email'] . "\n";
        echo "  - User Role: " . $_SESSION['user']['role'] . "\n\n";
        echo "✅ LOGIN SUCCESSFUL!\n";
    } else {
        echo "⚠ Session not created, but no errors\n";
        echo "Output: " . $output . "\n";
    }
} catch (\Exception $e) {
    ob_end_clean();
    echo "✗ Error: " . $e->getMessage() . "\n";
}

echo "\n=== Test Complete ===\n";
?>
