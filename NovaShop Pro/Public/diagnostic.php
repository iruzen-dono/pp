<?php
/**
 * NovaShop Pro - Diagnostic Système
 * Accédez à: http://localhost:8000/diagnostic.php
 */

$db = null;
$db_error = '';

// Tentative de connexion DB
if (file_exists(__DIR__ . '/../App/Config/Database.php')) {
    try {
        require_once __DIR__ . '/../App/Config/Database.php';
        $db = \App\Config\Database::getConnection();
    } catch (Throwable $e) {
        $db_error = $e->getMessage();
    }
}

// Démarrer session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>NovaShop Pro - Diagnostic</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #0f0c1d; color: #eee; padding: 20px; margin: 0; }
        .container { max-width: 900px; margin: 0 auto; }
        h1 { color: #b388ff; margin-bottom: 10px; }
        h2 { color: #b388ff; margin-top: 30px; border-bottom: 2px solid #b388ff; padding-bottom: 10px; }
        .check { padding: 10px; margin: 5px 0; border-left: 4px solid; border-radius: 4px; background: #1a1433; }
        .check.ok { background: #1a3a1a; border-color: #00ff00; }
        .check.warning { background: #3a3a1a; border-color: #ffff00; }
        .check.error { background: #3a1a1a; border-color: #ff0000; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: #1a1433; }
        th, td { padding: 10px; text-align: left; border: 1px solid #333; }
        th { background: #2a1a4a; font-weight: bold; }
        tr:hover { background: #2a1a4a; }
        .footer { color: #888; font-size: 12px; text-align: center; margin-top: 40px; }
    </style>
</head>
<body>
<div class="container">

<h1>🔧 Diagnostic - NovaShop Pro</h1>
<p>Date: <?php echo date('Y-m-d H:i:s'); ?></p>

<h2>📌 Configuration PHP</h2>

<?php
$php_version = phpversion();
$php_ok = version_compare($php_version, '8.0.0', '>=');
?>
<div class="check <?php echo $php_ok ? 'ok' : 'error'; ?>">
    <strong><?php echo $php_ok ? '✅' : '❌'; ?> Version PHP</strong><br>
    Requis: 8.0+ | Actuel: <?php echo $php_version; ?>
</div>

<?php
$extensions = ['pdo', 'pdo_mysql', 'session', 'json', 'mbstring'];
foreach ($extensions as $ext) {
    $loaded = extension_loaded($ext);
    ?>
    <div class="check <?php echo $loaded ? 'ok' : 'error'; ?>">
        <strong><?php echo $loaded ? '✅' : '❌'; ?> Extension: <?php echo $ext; ?></strong><br>
        Requis: Installée | Actuel: <?php echo $loaded ? 'Oui' : 'Non'; ?>
    </div>
    <?php
}
?>

<?php
$display_errors = ini_get('display_errors');
?>
<div class="check <?php echo !$display_errors ? 'ok' : 'warning'; ?>">
    <strong><?php echo !$display_errors ? '✅' : '⚠️'; ?> display_errors</strong><br>
    Requis: Off (prod) | Actuel: <?php echo $display_errors ? 'On' : 'Off'; ?>
</div>

<h2>📁 Structure des fichiers</h2>

<?php
$files = [
    'index.php' => 'Point d\'entrée',
    '../App/Core/App.php' => 'Classe App',
    '../App/Core/Router.php' => 'Routeur',
    '../App/Core/Model.php' => 'Classe Model',
    '../App/Core/Controller.php' => 'Classe Controller',
    '../App/Config/Database.php' => 'Connexion BD',
    '../App/Controllers/HomeController.php' => 'HomeController',
    '../App/Models/User.php' => 'Modèle User',
    '../App/Views/Layouts/header.php' => 'Layout header',
    'Assets/Css/Style.css' => 'Stylesheet',
];
?>

<table>
    <tr>
        <th>Fichier</th>
        <th>Status</th>
        <th>Description</th>
    </tr>
    <?php
    foreach ($files as $file => $desc) {
        $path = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $file);
        $exists = file_exists($path);
        ?>
        <tr class="<?php echo $exists ? 'ok' : 'error'; ?>">
            <td><?php echo htmlspecialchars($file); ?></td>
            <td><?php echo $exists ? '✅ Existe' : '❌ Manquant'; ?></td>
            <td><?php echo htmlspecialchars($desc); ?></td>
        </tr>
        <?php
    }
    ?>
</table>

<h2>🗄️ Base de données</h2>

<?php
if ($db !== null) {
    ?>
    <div class="check ok">
        <strong>✅ Connexion MySQL</strong><br>
        Connecté à: localhost / novashop
    </div>

    <table>
        <tr>
            <th>Table</th>
            <th>Status</th>
            <th>Lignes</th>
        </tr>
        <?php
        $tables = ['users', 'products', 'categories', 'orders', 'order_items'];
        foreach ($tables as $table) {
            try {
                $result = $db->query("SELECT COUNT(*) as count FROM " . $table);
                $row = $result->fetch(PDO::FETCH_ASSOC);
                $count = $row['count'] ?? 0;
                ?>
                <tr class="ok">
                    <td><?php echo htmlspecialchars($table); ?></td>
                    <td>✅ Existe</td>
                    <td><?php echo htmlspecialchars((string)$count); ?></td>
                </tr>
                <?php
            } catch (Throwable $e) {
                ?>
                <tr class="error">
                    <td><?php echo htmlspecialchars($table); ?></td>
                    <td>❌ Manquante</td>
                    <td>?</td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    <?php
} else {
    ?>
    <div class="check error">
        <strong>❌ Erreur de connexion</strong><br>
        Erreur: <?php echo htmlspecialchars($db_error ?: 'Connexion impossible'); ?>
    </div>
    <?php
}
?>

<h2>🔐 Sessions</h2>

<?php
$session_ok = session_status() === PHP_SESSION_ACTIVE;
?>
<div class="check <?php echo $session_ok ? 'ok' : 'error'; ?>">
    <strong><?php echo $session_ok ? '✅' : '❌'; ?> Sessions PHP</strong><br>
    Statut: <?php echo $session_ok ? 'Activées' : 'Désactivées'; ?>
</div>

<?php
$user_logged = isset($_SESSION['user']);
?>
<div class="check <?php echo $user_logged ? 'ok' : 'warning'; ?>">
    <strong><?php echo $user_logged ? '✅' : '⚠️'; ?> Utilisateur connecté</strong><br>
    Status: <?php echo $user_logged ? 'Oui (' . htmlspecialchars($_SESSION['user']['email'] ?? 'Email inconnu') . ')' : 'Non'; ?>
</div>

<h2>🔑 Permissions des fichiers</h2>

<?php
$dirs = [
    '' => 'Public (cette dir)',
    '../App/Views' => 'Views',
    'Assets' => 'Assets',
];
?>

<table>
    <tr>
        <th>Dossier</th>
        <th>Chemin</th>
        <th>Accessible</th>
    </tr>
    <?php
    foreach ($dirs as $dir => $label) {
        $path = __DIR__ . ($dir ? DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $dir) : '');
        $is_readable = is_readable($path);
        ?>
        <tr class="<?php echo $is_readable ? 'ok' : 'error'; ?>">
            <td><?php echo htmlspecialchars($label); ?></td>
            <td><?php echo htmlspecialchars($dir ?: '/'); ?></td>
            <td><?php echo $is_readable ? '✅ Oui' : '❌ Non'; ?></td>
        </tr>
        <?php
    }
    ?>
</table>

<h2>💡 Recommandations</h2>

<?php
$recommendations = [
    ['text' => 'Démarrer MySQL', 'priority' => $db === null],
    ['text' => 'Valider les formulaires côté serveur', 'priority' => true],
    ['text' => 'Implémenter CSRF tokens', 'priority' => true],
    ['text' => 'Ajouter rate limiting', 'priority' => true],
    ['text' => 'Configurer HTTPS en production', 'priority' => true],
];

foreach ($recommendations as $rec) {
    $class = $rec['priority'] ? 'warning' : 'ok';
    $status = $rec['priority'] ? '⚠️' : '✅';
    ?>
    <div class="check <?php echo $class; ?>">
        <strong><?php echo $status; ?> <?php echo htmlspecialchars($rec['text']); ?></strong>
    </div>
    <?php
}
?>

<h2>ℹ️ Informations système</h2>

<table>
    <tr>
        <th>Info</th>
        <th>Valeur</th>
    </tr>
    <tr>
        <td>Serveur</td>
        <td><?php echo htmlspecialchars($_SERVER['SERVER_SOFTWARE'] ?? 'N/A'); ?></td>
    </tr>
    <tr>
        <td>PHP SAPI</td>
        <td><?php echo htmlspecialchars(php_sapi_name()); ?></td>
    </tr>
    <tr>
        <td>OS</td>
        <td><?php echo htmlspecialchars(php_uname()); ?></td>
    </tr>
    <tr>
        <td>Répertoire courant</td>
        <td><?php echo htmlspecialchars(__DIR__); ?></td>
    </tr>
    <tr>
        <td>Mémoire utilisée</td>
        <td><?php echo round(memory_get_usage() / 1024 / 1024, 2); ?> MB</td>
    </tr>
    <tr>
        <td>Max upload</td>
        <td><?php echo htmlspecialchars(ini_get('upload_max_filesize')); ?></td>
    </tr>
</table>

<hr>
<div class="footer">
    <p>Généré par NovaShop Pro Diagnostic - <?php echo date('Y-m-d H:i:s'); ?></p>
</div>

</div>
</body>
</html>
