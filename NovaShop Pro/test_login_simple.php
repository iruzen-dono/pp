<?php
echo "=== Testing Login Flow ===\n\n";

// Test 1: Get login page and extract CSRF token
echo "[1] Fetching login page...\n";
$loginPage = file_get_contents('http://novashop.local/login');

preg_match('/<input[^>]*name=["\']_csrf["\'][^>]*value=["\']([^"\']+)["\']/', $loginPage, $matches);
$csrfToken = $matches[1] ?? null;

if (!$csrfToken) {
    echo "❌ Could not find CSRF token\n";
    exit(1);
}
echo "✓ Found CSRF token\n";

// Test 2: Try to login with valid credentials
echo "\n[2] Testing login with valid credentials...\n";

$postData = http_build_query([
    'email' => 'admin@novashop.local',
    'password' => 'admin123',
    '_csrf' => $csrfToken
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => [
            'Content-type: application/x-www-form-urlencoded',
            'Content-Length: ' . strlen($postData)
        ],
        'content' => $postData,
        'max_redirects' => 0  // Don't follow redirects
    ]
]);

try {
    $response = @file_get_contents('http://novashop.local/login', false, $context);
    
    // Check HTTP headers
    $httpCode = 0;
    if (isset($http_response_header)) {
        preg_match('/HTTP\/\d\.\d (\d+)/', $http_response_header[0], $m);
        $httpCode = (int)$m[1] ?? 0;
    }
    
    echo "HTTP Response Code: $httpCode\n";
    
    if ($httpCode === 302 || $httpCode === 301) {
        echo "✓ Redirect detected (login successful!)\n";
        foreach ($http_response_header as $h) {
            if (stripos($h, 'Location') === 0) {
                echo "  Redirect to: " . trim(substr($h, 10)) . "\n";
            }
        }
    } else if ($response) {
        // Check for error messages
        if (preg_match('/alert[^>]*alert-danger[^>]*>([^<]+)</i', $response, $m)) {
            echo "❌ Login error: " . trim(strip_tags($m[1])) . "\n";
        } else if (preg_match('/Se Connecter/i', $response)) {
            echo "ℹ Login form still shown (may indicate invalid credentials or POST issue)\n";
        }
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

// Test 3: Test with wrong password
echo "\n[3] Testing login with wrong password...\n";
$wrongData = http_build_query([
    'email' => 'admin@novashop.local',
    'password' => 'wrongpassword',
    '_csrf' => $csrfToken
]);

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-type: application/x-www-form-urlencoded',
        'content' => $wrongData,
    ]
]);

$response = @file_get_contents('http://novashop.local/login', false, $context);
if (preg_match('/incorrect/i', $response)) {
    echo "✓ Proper error message for wrong password\n";
} else {
    echo "✗ No error message for wrong password\n";
}

echo "\n✅ Login tests completed\n";
?>
