<style>
    .dashboard-header {
        margin-bottom: 50px;
    }

    .dashboard-header h1 {
        font-size: 42px;
        margin-bottom: 10px;
    }

    .dashboard-subtitle {
        color: #999;
        font-size: 16px;
        margin-bottom: 30px;
    }

    .feature-cards-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 25px;
        margin-top: 40px;
    }

    .feature-card-modern {
        background: linear-gradient(135deg, rgba(212, 165, 116, 0.1) 0%, rgba(212, 165, 116, 0.05) 100%);
        border: 2px solid rgba(212, 165, 116, 0.3);
        border-radius: 16px;
        padding: 35px;
        text-align: center;
        text-decoration: none;
        color: #e0e0e0;
        transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .feature-card-modern::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(212, 165, 116, 0.2), transparent);
        transition: left 0.5s ease;
        z-index: 0;
    }

    .feature-card-modern:hover::before {
        left: 100%;
    }

    .feature-card-modern > * {
        position: relative;
        z-index: 1;
    }

    .feature-card-modern:hover {
        border-color: #d4a574;
        background: linear-gradient(135deg, rgba(212, 165, 116, 0.15) 0%, rgba(212, 165, 116, 0.08) 100%);
        transform: translateY(-12px);
        box-shadow: 0 20px 48px rgba(212, 165, 116, 0.25);
    }

    .feature-icon {
        font-size: 48px;
        margin-bottom: 20px;
        display: block;
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0px); }
        50% { transform: translateY(-10px); }
    }

    .feature-card-modern h3 {
        margin: 0 0 12px 0;
        color: #d4a574;
        font-size: 18px;
    }

    .feature-card-modern p {
        margin: 0;
        color: #999;
        font-size: 13px;
        line-height: 1.6;
    }

    .stat-card {
        position: relative;
    }

    .stat-card-icon {
        font-size: 32px;
        margin-bottom: 15px;
    }
</style>

<div class="dashboard-header">
    <h1>✨ Bienvenue au Tableau de Bord</h1>
    <p class="dashboard-subtitle">Gérez votre boutique NovaShop Pro avec efficacité</p>
</div>

<div class="admin-stats">
    <div class="stat-card">
        <div class="stat-card-icon">👥</div>
        <p class="stat-label">Utilisateurs Actifs</p>
        <p class="stat-value"><?php echo $users_count ?? 0; ?></p>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-icon">📦</div>
        <p class="stat-label">Produits en Catalogue</p>
        <p class="stat-value"><?php echo $products_count ?? 0; ?></p>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-icon">🛒</div>
        <p class="stat-label">Commandes Totales</p>
        <p class="stat-value"><?php echo $orders_count ?? 0; ?></p>
    </div>
</div>

<h2 style="margin-top: 50px; margin-bottom: 30px;">🎯 Accès Rapide</h2>

<div class="feature-cards-grid">
    <a href="/admin/users" class="feature-card-modern">
        <span class="feature-icon">👥</span>
        <h3>Utilisateurs</h3>
        <p>Gérer les comptes et permissions</p>
    </a>

    <a href="/admin/products" class="feature-card-modern">
        <span class="feature-icon">📦</span>
        <h3>Produits</h3>
        <p>Ajouter, éditer ou supprimer</p>
    </a>

    <a href="/admin/orders" class="feature-card-modern">
        <span class="feature-icon">🛒</span>
        <h3>Commandes</h3>
        <p>Suivre les ventes en temps réel</p>
    </a>

    <a href="/" class="feature-card-modern">
        <span class="feature-icon">🌐</span>
        <h3>Site Public</h3>
        <p>Visualiser la boutique</p>
    </a>
</div>

<script>
    // Auto-refresh dashboard every 30 seconds (30000 ms)
    // Change the interval value to refresh more/less frequently
    const REFRESH_INTERVAL = 30000; // 30 seconds
    
    // Get current scroll position before refresh
    let scrollPosition = 0;
    window.addEventListener('beforeunload', function() {
        scrollPosition = window.scrollY;
        sessionStorage.setItem('dashboardScroll', scrollPosition);
    });
    
    // Restore scroll position after refresh
    window.addEventListener('load', function() {
        const savedScroll = sessionStorage.getItem('dashboardScroll');
        if (savedScroll) {
            window.scrollTo(0, parseInt(savedScroll));
            sessionStorage.removeItem('dashboardScroll');
        }
    });
    
    // Set up auto-refresh
    setInterval(function() {
        location.reload();
    }, REFRESH_INTERVAL);
</script>