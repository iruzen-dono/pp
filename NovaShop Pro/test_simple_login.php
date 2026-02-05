<?php
// Test login functionality
echo "=== LOGIN TEST ===\n\n";

// Step 1: Get login page
$loginPage = file_get_contents('http://novashop.local/login');
if (!$loginPage) {
    echo "ERROR: Could not fetch login page\n";
    exit(1);
}

// Step 2: Extract CSRF token
preg_match('/<input[^>]*name=["\']_csrf["\'].*?value=["\']([^"\']+)["\']/', $loginPage, $matches);
$csrfToken = $matches[1] ?? null;

if (!$csrfToken) {
    echo "ERROR: CSRF token not found\n";
    exit(1);
}

echo "CSRF token found\n";

// Step 3: Try login with test credentials
$testUsers = [
    ['admin@novashop.com', 'admin123'],
    ['test@example.com', 'password123'],
];

foreach ($testUsers as list($email, $pass)) {
    echo "\nTrying: $email\n";
    
    $data = http_build_query([
        '_csrf' => $csrfToken,
        'email' => $email,
        'password' => $pass
    ]);
    
    $opts = [
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => $data,
            'ignore_errors' => true
        ]
    ];
    
    $ctx = stream_context_create($opts);
    $result = @file_get_contents('http://novashop.local/login', false, $ctx);
    
    if (isset($http_response_header)) {
        $status = $http_response_header[0];
        echo "Response: $status\n";
    }
}
?>
