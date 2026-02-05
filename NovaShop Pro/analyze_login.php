<?php
$response = file_get_contents('http://novashop.local/login');
echo "=== LOGIN PAGE ANALYSIS ===\n";
echo "Size: " . strlen($response) . " bytes\n";

// Check for common error markers
$errors = [];
if (strpos($response, 'Fatal error') !== false) $errors[] = "Fatal error";
if (strpos($response, 'Parse error') !== false) $errors[] = "Parse error";
if (strpos($response, 'Exception') !== false) $errors[] = "Exception";
if (strpos($response, 'Undefined') !== false) $errors[] = "Undefined variable/function";
if (strpos($response, 'Call to undefined') !== false) $errors[] = "Call to undefined";
if (strpos($response, 'Class not found') !== false) $errors[] = "Class not found";

if (empty($errors)) {
    echo "✓ No obvious errors found\n";
} else {
    echo "✗ Errors detected:\n";
    foreach ($errors as $err) {
        echo "  - $err\n";
    }
}

// Extract error messages if any
if (preg_match_all('/<div[^>]*class=["\']alert[^"\']*["\'][^>]*>([^<]*)</i', $response, $matches)) {
    echo "\nAlert messages:\n";
    foreach ($matches[1] as $msg) {
        echo "  - " . trim(strip_tags($msg)) . "\n";
    }
}

// Check if login form exists
if (strpos($response, 'loginForm') !== false || strpos($response, 'login') !== false) {
    echo "\n✓ Login form found in page\n";
} else {
    echo "\n✗ Login form NOT found\n";
}
?>
