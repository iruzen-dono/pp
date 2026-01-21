<?php
/**
 * NovaShop Pro - Diagnostic Système
 * 
 * Accédez à: http://localhost:8000/diagnostic.php
 * Affiche l'état du système et identifie les problèmes
 */

echo "<!DOCTYPE html>";
echo "<html>";
echo "<head>";
echo "<title>NovaShop Pro - Diagnostic</title>";
echo "<style>";
echo "body { font-family: Arial; background: #0f0c1d; color: #eee; padding: 20px; }";
echo ".container { max-width: 900px; margin: 0 auto; }";
echo "h1 { color: #b388ff; }";
echo ".check { padding: 10px; margin: 5px 0; border-left: 4px solid; border-radius: 4px; }";
echo ".ok { background: #1a3a1a; border-color: #00ff00; }";
echo ".warning { background: #3a3a1a; border-color: #ffff00; }";
echo ".error { background: #3a1a1a; border-color: #ff0000; }";
echo "table { width: 100%; border-collapse: collapse; margin-top: 20px; }";
echo "th, td { padding: 10px; text-align: left; border: 1px solid #333; }";
echo "th { background: #1a1433; }";
echo ".status { font-weight: bold; }";
echo "</style>";
echo "</head>";
echo "<body>";
echo "<div class='container'>";

echo "<h1>🔧 Diagnostic - NovaShop Pro</h1>";
echo "<p>Date: " . date('Y-m-d H:i:s') . "</p>";

// ==========================================
// VÉRIFICATIONS PHP
// ==========================================

echo "<h2>📌 Configuration PHP</h2>";

$checks = [];

// Version PHP
$php_version = phpversion();
$checks['PHP Version'] = [
    'required' => '8.0+',
    'actual' => $php_version,
    'ok' => version_compare($php_version, '8.0.0', '>=')
];

// Extensions requises
$extensions = ['pdo', 'pdo_mysql', 'session', 'json', 'mbstring'];
foreach ($extensions as $ext) {
    $checks["Extension: $ext"] = [
        'required' => 'Installée',
        'actual' => extension_loaded($ext) ? 'Oui' : 'Non',
        'ok' => extension_loaded($ext)
    ];
}

// Sécurité
$checks['display_errors'] = [
    'required' => 'Off (prod)',
    'actual' => ini_get('display_errors') ? 'On' : 'Off',
    'ok' => !ini_get('display_errors')
];

foreach ($checks as $name => $data) {
    $class = $data['ok'] ? 'ok' : 'error';
    $status = $data['ok'] ? '✅' : '❌';
    echo "<div class='check $class'>";
    echo "<strong>$status $name</strong><br>";
    echo "Requis: {$data['required']} | Actuel: {$data['actual']}";
    echo "</div>";
}

// ==========================================
// VÉRIFICATIONS FICHIERS
// ==========================================

echo "<h2>📁 Structure des fichiers</h2>";

$files = [
    'index.php' => 'Point d\'entrée',
    '../App/Core/App.php' => 'Classe App',
    '../App/Core/Router.php' => 'Routeur',
    '../App/Core/Model.php' => 'Classe Model',
    '../App/Core/Controller.php' => 'Classe Controller',
    '../App/Config/Database.php' => 'Connexion BD',
    '../App/Controllers/HomeController.php' => 'HomeController',
    '../App/Controllers/AuthController.php' => 'AuthController',
    '../App/Models/User.php' => 'Modèle User',
    '../App/Views/Layouts/header.php' => 'Layout header',
    'Assets/Css/Style.css' => 'Stylesheet',
];

echo "<table>";
echo "<tr><th>Fichier</th><th>Status</th><th>Description</th></tr>";

$base_path = __DIR__;
foreach ($files as $file => $desc) {
    $path = $base_path . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
    $exists = file_exists($path);
    $status = $exists ? '✅ Existe' : '❌ Manquant';
    $class = $exists ? 'ok' : 'error';
    echo "<tr class='$class'>";
    echo "<td>$file</td>";
    echo "<td>$status</td>";
    echo "<td>$desc</td>";
    echo "</tr>";
}

echo "</table>";

// ==========================================
// VÉRIFICATIONS BASE DE DONNÉES
// ==========================================

echo "<h2>🗄️ Base de données</h2>";

try {
    require_once __DIR__ . '/../App/Config/Database.php';
    
    use App\Config\Database;
    
    $db = Database::getConnection();
    
    echo "<div class='check ok'>";
    echo "<strong>✅ Connexion MySQL</strong><br>";
    echo "Connecté à: localhost / novashop";
    echo "</div>";
    
    // Vérifier les tables
    $tables = ['users', 'products', 'categories', 'orders', 'order_items'];
    
    echo "<table>";
    echo "<tr><th>Table</th><th>Status</th><th>Lignes</th></tr>";
    
    foreach ($tables as $table) {
        try {
            $result = $db->query("SELECT COUNT(*) as count FROM $table");
            $count = $result->fetch()['count'];
            $status = '✅ Existe';
            $class = 'ok';
        } catch (Exception $e) {
            $count = '?';
            $status = '❌ Manquante';
            $class = 'error';
        }
        
        echo "<tr class='$class'>";
        echo "<td>$table</td>";
        echo "<td>$status</td>";
        echo "<td>$count</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch (Exception $e) {
    echo "<div class='check error'>";
    echo "<strong>❌ Erreur de connexion</strong><br>";
    echo "Erreur: " . htmlspecialchars($e->getMessage());
    echo "</div>";
}

// ==========================================
// VÉRIFICATIONS SESSIONS
// ==========================================

echo "<h2>🔐 Sessions</h2>";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$session_ok = isset($_SESSION);
$user_logged = isset($_SESSION['user']);

echo "<div class='check " . ($session_ok ? 'ok' : 'error') . "'>";
echo "<strong>" . ($session_ok ? '✅' : '❌') . " Sessions PHP</strong><br>";
echo "Statut: " . ($session_ok ? 'Activées' : 'Désactivées');
echo "</div>";

echo "<div class='check " . ($user_logged ? 'ok' : 'warning') . "'>";
echo "<strong>" . ($user_logged ? '✅' : '⚠️') . " Utilisateur connecté</strong><br>";
echo "Status: " . ($user_logged ? 'Oui (' . htmlspecialchars($_SESSION['user']['email']) . ')' : 'Non');
echo "</div>";

// ==========================================
// VÉRIFICATIONS PERMISSIONS
// ==========================================

echo "<h2>🔑 Permissions des fichiers</h2>";

$dirs = [
    '' => '0755',
    '../App/Views' => '0755',
    'Assets' => '0777',
];

echo "<table>";
echo "<tr><th>Dossier</th><th>Permissions</th><th>Accessible</th></tr>";

$base_path = __DIR__;
foreach ($dirs as $dir => $required_perms) {
    $path = $base_path . ($dir ? DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $dir) : '');
    $is_readable = is_readable($path);
    $is_writable = is_writable($path);
    $status = $is_readable ? '✅ Oui' : '❌ Non';
    $class = $is_readable ? 'ok' : 'error';
    
    echo "<tr class='$class'>";
    echo "<td>$dir</td>";
    echo "<td>Requis: $required_perms</td>";
    echo "<td>$status</td>";
    echo "</tr>";
}

echo "</table>";

// ==========================================
// RECOMMANDATIONS
// ==========================================

echo "<h2>💡 Recommandations</h2>";

$recommendations = [
    'Démarrer MySQL' => !isset($db),
    'Créer la base de données' => false, // On ne peut pas vérifier facilement
    'Vérifier les permissions' => false,
    'Valider les formulaires côté serveur' => true,
    'Implémenter CSRF tokens' => true,
    'Ajouter rate limiting' => true,
    'Configurer HTTPS en production' => true,
];

foreach ($recommendations as $rec => $priority) {
    $class = $priority ? 'warning' : 'ok';
    echo "<div class='check $class'>";
    echo "<strong>$rec</strong>";
    echo "</div>";
}

// ==========================================
// INFORMATIONS SYSTÈME
// ==========================================

echo "<h2>ℹ️ Informations système</h2>";

echo "<table>";
echo "<tr><th>Info</th><th>Valeur</th></tr>";
echo "<tr><td>Serveur</td><td>" . $_SERVER['SERVER_SOFTWARE'] . "</td></tr>";
echo "<tr><td>PHP SAPI</td><td>" . php_sapi_name() . "</td></tr>";
echo "<tr><td>OS</td><td>" . php_uname() . "</td></tr>";
echo "<tr><td>Répertoire courant</td><td>" . __DIR__ . "</td></tr>";
echo "<tr><td>Mémoire utilisée</td><td>" . round(memory_get_usage() / 1024 / 1024, 2) . " MB</td></tr>";
echo "<tr><td>Max upload</td><td>" . ini_get('upload_max_filesize') . "</td></tr>";
echo "</table>";

echo "<hr style='margin: 40px 0; border: 1px solid #333;'>";
echo "<p style='color: #888; font-size: 12px;'>Généré par NovaShop Pro Diagnostic - " . date('Y-m-d H:i:s') . "</p>";

echo "</div>";
echo "</body>";
echo "</html>";
?>
