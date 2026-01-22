<?php
// App/Views/Admin/layout.php - ADMIN SIDEBAR LAYOUT
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - NovaShop Pro</title>
    <link rel="stylesheet" href="/assets/css/style.css">
    <style>
        /* Admin specific styles override */
        body {
            margin: 0;
            padding: 0;
        }
    </style>
</head>
<body>
    <!-- HEADER NAVIGATION -->
    <header>
        <nav>
            <div class="navbar-brand">NovaShop Pro</div>
            <div class="nav-links" style="margin-left: auto;">
                <span style="color: var(--gray-300); font-size: 0.95rem;">
                    👤 Admin Panel
                </span>
                <a href="/logout" class="btn btn-danger" style="padding: 0.5rem 1rem; font-size: 0.9rem;">Déconnexion</a>
            </div>
        </nav>
    </header>

    <div class="admin-wrapper">
        <!-- SIDEBAR NAVIGATION -->
        <aside class="admin-sidebar">
            <div class="admin-header">
                <h2>Admin</h2>
                <p style="color: var(--gray-400); font-size: 0.9rem;">Gestion du site</p>
            </div>

            <ul class="admin-nav">
                <li>
                    <a href="/admin/dashboard" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/dashboard') !== false ? 'active' : ''; ?>">
                        📊 Tableau de Bord
                    </a>
                </li>
                <li>
                    <a href="/admin/users" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/users') !== false ? 'active' : ''; ?>">
                        👥 Utilisateurs
                    </a>
                </li>
                <li>
                    <a href="/admin/products" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/products') !== false ? 'active' : ''; ?>">
                        📦 Produits
                    </a>
                </li>
                <li>
                    <a href="/admin/orders" class="<?php echo strpos($_SERVER['REQUEST_URI'], '/orders') !== false ? 'active' : ''; ?>">
                        🛒 Commandes
                    </a>
                </li>
                <li style="border-top: 1px solid rgba(99, 102, 241, 0.2); margin-top: 1rem; padding-top: 1rem;">
                    <a href="/" style="color: var(--accent);">
                        🏠 Accueil
                    </a>
                </li>
            </ul>
        </aside>

        <!-- MAIN CONTENT -->
        <main class="admin-content">
            <?php echo $content ?? ''; ?>
        </main>
    </div>
</body>
</html>
