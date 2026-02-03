<?php
/**
 * Test Bootstrap
 * Initializes test environment and database connection
 */

// Define base path
define('BASE_PATH', dirname(__DIR__));

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', '1');

// Autoload
require_once BASE_PATH . '/Public/index.php';
