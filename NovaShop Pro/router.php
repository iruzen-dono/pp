<?php
/**
 * Router pour le serveur PHP intégré
 * Utilisation: php -S localhost:8000 router.php
 */

$requestUri = $_SERVER['REQUEST_URI'];
$publicDir = __DIR__ . '/Public';

// Extraire le chemin
$uri = parse_url($requestUri, PHP_URL_PATH);
$uri = ltrim($uri, '/');

// Servir les fichiers statiques
if ($uri && $uri !== 'index.php') {
    $file = $publicDir . '/' . $uri;
    if (is_file($file)) {
        return false;
    }
}

// Extraire le paramètre URL (sans index.php)
if ($uri && $uri !== 'index.php') {
    $_GET['url'] = $uri;
} else {
    $_GET['url'] = 'home';
}

require $publicDir . '/index.php';
