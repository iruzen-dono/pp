<?php
/**
 * Router pour le serveur PHP intégré
 * Utilisation: php -S localhost:8000 router.php
 */

// Récupérer l'URL demandée
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requested_file = __DIR__ . $uri;

// Servir les fichiers statiques (CSS, JS, images, etc.)
if (is_file($requested_file)) {
    return false;
}

// Servir les répertoires statiques
if (is_dir($requested_file) && is_file($requested_file . '/index.html')) {
    return false;
}

// Tout le reste va vers index.php
require __DIR__ . '/index.php';
