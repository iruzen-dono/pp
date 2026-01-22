<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaShop - E-commerce MVC</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header class="navbar">
        <a href="/" class="logo"><span style="color: var(--accent);">◆</span> NovaShop</a>
        <nav>
            <a href="/">Accueil</a>
            <a href="/products">Produits</a>
            <a href="/cart"><span style="color: var(--accent);">⊙</span> Panier</a>
            
            <?php if (isset($_SESSION['user'])): ?>
                <a href="/orders"><span style="color: var(--accent);">□</span> Mes commandes</a>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/admin/dashboard"><span style="color: var(--accent);">⚙</span> Admin</a>
                <?php endif; ?>
                <a href="/logout"><span style="color: var(--accent);">→</span> Déconnexion</a>
            <?php else: ?>
                <a href="/login"><span style="color: var(--accent);">🔒</span> Connexion</a>
                <a href="/register"><span style="color: var(--accent);">✚</span> S'inscrire</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container">
