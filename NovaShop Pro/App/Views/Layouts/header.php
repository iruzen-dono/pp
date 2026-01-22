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
        <a href="/" class="logo">NovaShop 🛍️</a>
        <nav>
            <a href="/">Accueil</a>
            <a href="/products">Produits</a>
            <a href="/cart">🛒 Panier</a>
            
            <?php if (isset($_SESSION['user'])): ?>
                <a href="/orders">📋 Mes commandes</a>
                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <a href="/admin/dashboard">⚙️ Admin</a>
                <?php endif; ?>
                <a href="/logout">👋 Déconnexion</a>
            <?php else: ?>
                <a href="/login">🔐 Connexion</a>
                <a href="/register">📝 S'inscrire</a>
            <?php endif; ?>
        </nav>
    </header>

    <main class="container">
