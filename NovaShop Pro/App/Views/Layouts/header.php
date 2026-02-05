<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaShop - Boutique Premium</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS - Centralized -->
    <link rel="stylesheet" href="/Assets/Css/variables.css">
    <link rel="stylesheet" href="/Assets/Css/utilities.css">
    <link rel="stylesheet" href="/Assets/Css/buttons.css">
    <link rel="stylesheet" href="/Assets/Css/ui-improvements.css">
    <link rel="stylesheet" href="/Assets/Css/Style.css">
    <!-- Component CSS (override dispersed rules in Style.css) -->
    <link rel="stylesheet" href="/Assets/Css/navbar.css">
    <link rel="stylesheet" href="/Assets/Css/cards.css">
    <link rel="stylesheet" href="/Assets/Css/products.css">
    <link rel="stylesheet" href="/Assets/Css/forms.css">
    <link rel="stylesheet" href="/Assets/Css/auth.css">
    <link rel="stylesheet" href="/Assets/Css/search-min.css">
    <link rel="stylesheet" href="/Assets/Css/animations.css">
    <!-- UI fixes loaded last to override troublesome rules -->
    <link rel="stylesheet" href="/Assets/Css/ui-fixes.css">
</head>
<body>
    <!-- Floating Utility Buttons -->
    <div class="utility-buttons">
        <button id="scrollTopBtn" title="Vers le haut" aria-label="Retour au haut" class="scroll-top-btn">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>

    <header class="navbar-header">
        <div class="navbar-container">
            <!-- Logo Section -->
            <div class="navbar-brand">
                <a href="/" class="logo">
                    <i class="fas fa-gem logo-icon"></i>
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
                            <i class="fas fa-home nav-icon"></i>
                            <span>Accueil</span>
                        </a>
                        <a href="/products" class="nav-link nav-link-products">
                            <i class="fas fa-shopping-bag nav-icon"></i>
                            <span>Produits</span>
                        </a>
                        <a href="/cart" class="nav-link nav-link-cart">
                            <i class="fas fa-cart-shopping nav-icon"></i>
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
                                <i class="fas fa-clipboard-list nav-icon"></i>
                                <span>Commandes</span>
                            </a>
                            <?php if (in_array($_SESSION['user']['role'] ?? '', ['admin', 'super_admin'])): ?>
                                <a href="/admin/dashboard" class="nav-link nav-link-admin nav-link-special">
                                    <i class="fas fa-cog nav-icon"></i>
                                    <span>Admin</span>
                                    <span class="admin-badge"><?php echo strtoupper($_SESSION['user']['role']); ?></span>
                                </a>
                            <?php endif; ?>
                            <button class="nav-link nav-link-logout user-menu-trigger" id="userMenuTrigger">
                                <i class="fas fa-user nav-icon"></i>
                                <span><?php echo htmlspecialchars($_SESSION['user']['name'] ?? 'Utilisateur'); ?></span>
                                <i class="fas fa-chevron-down" style="font-size: 0.8rem; margin-left: 0.3rem;"></i>
                            </button>
                            <div class="user-dropdown" id="userDropdown" style="display: none;">
                                <a href="/profile" class="dropdown-item"><i class="fas fa-user-circle"></i> Profil</a>
                                <a href="/settings" class="dropdown-item"><i class="fas fa-sliders-h"></i> Paramètres</a>
                                <hr class="dropdown-divider">
                                <a href="/logout" class="dropdown-item dropdown-danger"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
                            </div>
                        <?php else: ?>
                            <a href="/login" class="nav-link nav-link-login">
                                <i class="fas fa-unlock nav-icon"></i>
                                <span>Connexion</span>
                            </a>
                            <a href="/register" class="nav-link nav-link-register nav-link-primary">
                                <i class="fas fa-sparkles nav-icon"></i>
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