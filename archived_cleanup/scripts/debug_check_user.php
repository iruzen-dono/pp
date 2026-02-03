<?php
require __DIR__ . '/../App/Config/Database.php';
require __DIR__ . '/../App/Core/Model.php';
require __DIR__ . '/../App/Models/User.php';

use App\Config\Database;
use App\Models\User;

// Bootstrap minimal
try {
    $db = Database::getConnection();
} catch (Exception $e) {
    echo "DB connection failed: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

$userId = $argv[1] ?? null;
if (!$userId) {
    echo "Usage: php debug_check_user.php <userId>\n";
    exit(2);
}

$user = (new User())->findById((int)$userId);
if (!$user) {
    echo "User not found\n";
    exit(3);
}

echo "User ID: " . $user['id'] . PHP_EOL;
echo "Email: " . $user['email'] . PHP_EOL;
echo "Password hash: " . $user['password'] . PHP_EOL;
echo "Email verified at: " . ($user['email_verified_at'] ?? 'NULL') . PHP_EOL;
echo "Is active: " . ($user['is_active'] ?? 'NULL') . PHP_EOL;

// Optionally verify a known password against the hash (for quick test)
if (isset($argv[2])) {
    $test = $argv[2];
    echo "Verifies '" . $test . "' => " . (password_verify($test, $user['password']) ? 'YES' : 'NO') . PHP_EOL;
}

?>
