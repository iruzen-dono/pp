<?php
echo "PHP SAPI: " . php_sapi_name() . PHP_EOL;
echo "PHP Version: " . PHP_VERSION . PHP_EOL;
echo "PDO extension loaded: " . (extension_loaded('pdo') ? 'yes' : 'no') . PHP_EOL;
if (extension_loaded('pdo')) {
    $drivers = PDO::getAvailableDrivers();
    echo "PDO drivers: " . (empty($drivers) ? '(none)' : implode(', ', $drivers)) . PHP_EOL;
} else {
    echo "PDO drivers: (pdo extension not loaded)" . PHP_EOL;
}
if (defined('PDO::MYSQL_ATTR_USE_BUFFERED_QUERY')) {
    echo "CONST PDO::MYSQL_ATTR_USE_BUFFERED_QUERY is defined" . PHP_EOL;
} else {
    echo "CONST PDO::MYSQL_ATTR_USE_BUFFERED_QUERY is NOT defined" . PHP_EOL;
}

// Print pdo_mysql info if available
if (extension_loaded('pdo_mysql')) {
    echo "pdo_mysql extension version: " . (defined('PDO::ATTR_DRIVER_NAME') ? 'available' : 'unknown') . PHP_EOL;
}

// Minimal phpinfo output for modules
ob_start();
phpinfo(INFO_MODULES);
$info = ob_get_clean();
// Print only a small excerpt around PDO
if (strpos($info, 'PDO') !== false) {
    $pos = strpos($info, 'PDO');
    echo "--- phpinfo(PDO section excerpt) ---\n";
    echo substr($info, $pos, 1200) . PHP_EOL;
}
