<?php
session_start();

// Test credentials
$email = 'test@example.com';
$password = 'password123';

// Get CSRF token first
$loginPage = file_get_contents('http://novashop.local/login');
preg_match('/<input[^>]*name=["\']_csrf["\'][^>]*value=["\']([^"\']+)["\']/', $loginPage, $matches);
$csrfToken = $matches[1] ?? '';

echo "CSRF Token: " . ($csrfToken ? 'Found' : 'NOT FOUND') . "\n";

// Try to login
$data = http_build_query([
    'email' => $email,
    'password' => $password,
    '_csrf' => $csrfToken
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $data,
        'cookie' => 'PHPSESSID=test123'
    ]
]);

$response = file_get_contents('http://novashop.local/login', false, $context);

echo "\n=== LOGIN RESPONSE ===\n";
echo "Response size: " . strlen($response) . " bytes\n";

// Check for specific errors
if (preg_match('/alert[^>]*>([^<]+)</i', $response, $m)) {
    echo "Alert message: " . trim($m[1]) . "\n";
}

// Check if redirected (would indicate successful login)
if (strpos($response, 'NovaShop') !== false && strlen($response) < 5000) {
    echo "✗ Possible redirect detected (small response)\n";
} else {
    echo "✓ Login form still displayed\n";
}
?>
