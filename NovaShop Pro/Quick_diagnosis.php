<?php
// Diagnostic script that goes through the application
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET['url'] = 'login';

// Capture any errors
ob_start();
$errorsDetected = [];

try {
    require_once __DIR__ . '/Public/index.php';
} catch (\Throwable $e) {
    $errorsDetected[] = [
        'type' => get_class($e),
        'message' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ];
}

$output = ob_get_clean();

if (empty($errorsDetected)) {
    echo "✓ Login page loads without errors\n";
    echo "Response length: " . strlen($output) . " bytes\n";
} else {
    echo "❌ Errors detected:\n";
    foreach ($errorsDetected as $err) {
        echo "Type: " . $err['type'] . "\n";
        echo "Message: " . $err['message'] . "\n";
        echo "File: " . $err['file'] . ":{$err['line']}\n\n";
    }
}
?>
