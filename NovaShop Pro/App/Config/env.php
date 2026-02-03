<?php
// Charger .env si présent (projet racine)
$root = dirname(__DIR__, 2);
$envPath = $root . '/.env';
if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#')) {
            continue;
        }
        $parts = explode('=', $line, 2);
        if (count($parts) === 2) {
            putenv(trim($parts[0]) . '=' . trim($parts[1]));
        }
    }
}

return [
    'db_host' => getenv('DB_HOST') ?: 'localhost',
    'db_name' => getenv('DB_NAME') ?: 'novashop',
    'db_user' => getenv('DB_USER') ?: 'root',
    'db_pass' => getenv('DB_PASS') ?: '0000',
];
