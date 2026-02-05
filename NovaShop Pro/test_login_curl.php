<?php
// Complete login test with cookie handling
$cookieFile = sys_get_temp_dir() . '/cookies.txt';
$email = 'admin@novashop.com';
$password = 'admin123';

echo "=== STEP 1: GET login page ===\n";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://novashop.local/login');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP Code: $httpCode\n";

// Extract CSRF token
preg_match('/<input[^>]*name=["\']_csrf["\'][^>]*value=["\']([^"\']+)["\']/', $response, $matches);
$csrfToken = $matches[1] ?? null;
echo "CSRF Token: " . ($csrfToken ? substr($csrfToken, 0, 10) . "..." : "NOT FOUND") . "\n";

if (!$csrfToken) {
    echo "❌ Could not find CSRF token in login page\n";
    curl_close($ch);
    exit(1);
}

echo "\n=== STEP 2: POST login credentials ===\n";
curl_setopt($ch, CURLOPT_URL, 'http://novashop.local/login');
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'email' => $email,
    'password' => $password,
    '_csrf' => $csrfToken
]));
curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile);
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // Don't follow redirects

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
echo "HTTP Code: $httpCode\n";

if ($httpCode === 302 || $httpCode === 301) {
    $location = curl_getinfo($ch, CURLINFO_REDIRECT_URL);
    echo "✓ Redirect to: $location\n";
} else {
    echo "Response length: " . strlen($response) . "\n";
    
    // Check for error
    if (preg_match('/<div[^>]*class="alert[^>]*alert-danger[^>]*">[^<]*<[^>]*>([^<]+)</i', $response, $m)) {
        echo "Error message: " . trim($m[1]) . "\n";
    }
}

curl_close($ch);
?>
