<?php
// Test actual login functionality
session_start();

echo "=== LOGIN FUNCTIONALITY TEST ===\n\n";

// Get page to extract CSRF token and simulate browser session
$loginPageContent = file_get_contents('http://novashop.local/login');

if (!$loginPageContent) {
    echo "❌ Failed to fetch login page\n";
    exit(1);
}

// Extract CSRF token from HTML
if (!preg_match('/<input[^>]*name=["\']_csrf["\'][^>]*value=["\']([^"\']+)["\']/', $loginPageContent, $matches)) {
    // Try alternative pattern
    preg_match('/<input[^>]*value=["\']([^"\']+)["\'][^>]*name=["\']_csrf/', $loginPageContent, $matches);
}

$csrfToken = $matches[2] ?? $matches[1] ?? null;

if (!$csrfToken) {
    echo "❌ CSRF token not found in login form\n";
    echo "Searching for form fields...\n";
    
    if (preg_match_all('/<input[^>]*name=["\'']([^"\']+)["\']/', $loginPageContent, $m)) {
        echo "Found input fields: " . implode(", ", $m[1]) . "\n";
    }
    exit(1);
}

echo "✓ CSRF token found: " . substr($csrfToken, 0, 16) . "...\n";

// Now try to login - we'll use a test user
// First, let's check what users exist by trying different credentials
$testCredentials = [
    ['email' => 'admin@novashop.com', 'password' => 'admin123'],
    ['email' => 'test@example.com', 'password' => 'password'],
    ['email' => 'admin@example.com', 'password' => 'password123'],
];

foreach ($testCredentials as $creds) {
    echo "\nTesting login with: {$creds['email']}\n";
    
    $postData = http_build_query([
        '_csrf' => $csrfToken,
        'email' => $creds['email'],
        'password' => $creds['password']
    ]);
    
    $context = stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => "Content-Type: application/x-www-form-urlencoded\r\nContent-Length: " . strlen($postData),
            'content' => $postData,
            'ignore_errors' => true
        ]
    ]);
    
    $response = @file_get_contents('http://novashop.local/login', false, $context);
    
    if ($http_response_header) {
        $statusLine = $http_response_header[0] ?? '';
        echo "Status: $statusLine\n";
        
        if (strpos($statusLine, '302') !== false || strpos($statusLine, '301') !== false) {
            echo "✓ Redirect detected (likely successful login)\n";
            break;
        } else {
            // Check for error message
            if ($response && preg_match('/<div[^>]*alert-danger[^>]*>.*?<strong>([^<]*)<\/strong>\s*([^<]*)</', $response, $m)) {
                echo "Error: " . trim($m[1] . " " . $m[2]) . "\n";
            } else {
                echo "No error detected in response\n";
            }
        }
    }
}
?>
