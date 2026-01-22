<?php

session_start();

// Extraire l'URL depuis $_GET['url'] OU depuis REQUEST_URI
if (empty($_GET['url'])) {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $uri = str_replace('/Public', '', $uri); // Ajuster selon votre structure
    $uri = ltrim($uri, '/');
    $_GET['url'] = $uri ?: 'home';
}

require_once __DIR__ . '/../App/Core/App.php';

use App\Core\App;

$app = new App();
$app->run();
