<?php
/**
 * Router pour le serveur PHP intégré
 * Utilisation: php -S localhost:8000 -t Public router.php
 */

$requested_file = __DIR__ . $_SERVER['REQUEST_URI'];
$requested_file = str_replace(array('\\', '//'), '/', $requested_file);

// Servir les fichiers statiques (assets, etc.)
if (is_file($requested_file) && is_dir(dirname($requested_file))) {
    return false;
}

// Tout le reste va vers index.php
require __DIR__ . '/index.php';
