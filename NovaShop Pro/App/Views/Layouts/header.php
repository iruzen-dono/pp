<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaShop - Boutique Premium</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <!-- Dark Mode Toggle -->
    <button id="darkModeToggle" class="theme-toggle" title="Mode sombre">🌙</button>

    <!-- Scroll to Top Button -->
    <button id="scrollTopBtn" title="Vers le haut">↑</button>

    <header>
        <nav>
            <a href="/" class="logo"><span>◆</span> NovaShop</a>
            <div style="display: flex; gap: 2rem; align-items: center;">
                <a href="/">Accueil</a>
                <a href="/products">Produits</a>
                <a href="/cart">Panier</a>
                
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="/orders">Commandes</a>
                    <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                        <a href="/admin/dashboard">Admin</a>
                    <?php endif; ?>
                    <a href="/logout">Déconnexion</a>
                <?php else: ?>
                    <a href="/login">Connexion</a>
                    <a href="/register">Inscription</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
