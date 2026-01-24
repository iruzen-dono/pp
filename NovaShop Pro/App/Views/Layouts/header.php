<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaShop - Boutique Premium</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <!-- Floating Utility Buttons -->
    <div class="utility-buttons">
        <button id="darkModeToggle" class="theme-toggle" title="Mode sombre" aria-label="Basculer mode sombre">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
            </svg>
        </button>
        <button id="scrollTopBtn" title="Vers le haut" aria-label="Retour au haut" class="scroll-top-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 19V5M5 12l7-7 7 7"></path>
            </svg>
        </button>
    </div>

    <header class="navbar-header">
        <div class="navbar-container">
            <!-- Logo Section -->
            <div class="navbar-brand">
                <a href="/" class="logo">
                    <span class="logo-icon">◆</span>
                    <span class="logo-text">NovaShop</span>
                    <span class="logo-badge">PREMIUM</span>
                </a>
            </div>

            <!-- Hamburger Menu for Mobile -->
            <button class="hamburger-menu" id="hamburgerMenu" aria-label="Menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <!-- Navigation Menu -->
            <nav class="navbar-menu">
                <div class="nav-links-wrapper">
                    <!-- Main Navigation -->
                    <div class="nav-group">
                        <a href="/" class="nav-link nav-link-home">
                            <span class="nav-icon">🏠</span>
                            <span>Accueil</span>
                        </a>
                        <a href="/products" class="nav-link nav-link-products">
                            <span class="nav-icon">🛍️</span>
                            <span>Produits</span>
                        </a>
                        <a href="/cart" class="nav-link nav-link-cart">
                            <span class="nav-icon">🛒</span>
                            <span>Panier</span>
                            <span class="cart-badge" id="cartBadge" style="display: none;">0</span>
                        </a>
                    </div>

                    <!-- Divider -->
                    <div class="nav-divider"></div>

                    <!-- User Navigation -->
                    <div class="nav-group">
                        <?php if (isset($_SESSION['user'])): ?>
                            <a href="/orders" class="nav-link nav-link-orders">
                                <span class="nav-icon">📋</span>
                                <span>Commandes</span>
                            </a>
                            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                                <a href="/admin/dashboard" class="nav-link nav-link-admin nav-link-special">
                                    <span class="nav-icon">⚙️</span>
                                    <span>Admin</span>
                                    <span class="admin-badge">ADMIN</span>
                                </a>
                            <?php endif; ?>
                            <button class="nav-link nav-link-logout user-menu-trigger" id="userMenuTrigger">
                                <span class="nav-icon">👤</span>
                                <span><?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Utilisateur'); ?></span>
                                <span class="dropdown-arrow">▼</span>
                            </button>
                            <div class="user-dropdown" id="userDropdown" style="display: none;">
                                <a href="/profile" class="dropdown-item">Profil</a>
                                <a href="/settings" class="dropdown-item">Paramètres</a>
                                <hr class="dropdown-divider">
                                <a href="/logout" class="dropdown-item dropdown-danger">Déconnexion</a>
                            </div>
                        <?php else: ?>
                            <a href="/login" class="nav-link nav-link-login">
                                <span class="nav-icon">🔓</span>
                                <span>Connexion</span>
                            </a>
                            <a href="/register" class="nav-link nav-link-register nav-link-highlight">
                                <span class="nav-icon">✨</span>
                                <span>S'inscrire</span>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </nav>
        </div>

        <!-- Navbar Underline Animation -->
        <div class="navbar-underline"></div>
    </header>

    <main>
    <script src="/assets/js/main.js"></script>