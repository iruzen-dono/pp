<?php
$_SERVER['REQUEST_METHOD'] = 'GET';
$_GET['url'] = 'login';
ob_start();
try {
    require_once 'Public/index.php';
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
}
$output = ob_get_clean();
echo substr($output, 0, 500);
?>
