<h1>📊 Tableau de Bord</h1>

<div class="admin-stats">
    <div class="stat-card">
        <p class="stat-label">👥 Utilisateurs</p>
        <p class="stat-value"><?php echo $users_count ?? 0; ?></p>
    </div>
    
    <div class="stat-card">
        <p class="stat-label">📦 Produits</p>
        <p class="stat-value"><?php echo $products_count ?? 0; ?></p>
    </div>
    
    <div class="stat-card">
        <p class="stat-label">🛒 Commandes</p>
        <p class="stat-value"><?php echo $orders_count ?? 0; ?></p>
    </div>
</div>

<div class="admin-stats" style="margin-top: 3rem;">
    <a href="/admin/users" class="feature-card" style="text-decoration: none; cursor: pointer; padding: 2rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">👥</div>
        <h3 style="margin-top: 0; color: #d4a574;">Gestion des Utilisateurs</h3>
        <p style="margin-bottom: 0;">Ajouter, modifier ou supprimer des utilisateurs</p>
    </a>

    <a href="/admin/products" class="feature-card" style="text-decoration: none; cursor: pointer; padding: 2rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">📦</div>
        <h3 style="margin-top: 0; color: #d4a574;">Gestion des Produits</h3>
        <p style="margin-bottom: 0;">Gérer le catalogue et les images</p>
    </a>

    <a href="/admin/orders" class="feature-card" style="text-decoration: none; cursor: pointer; padding: 2rem; text-align: center;">
        <div style="font-size: 3rem; margin-bottom: 1rem;">🛒</div>
        <h3 style="margin-top: 0; color: #d4a574;">Gestion des Commandes</h3>
        <p style="margin-bottom: 0;">Voir et gérer toutes les commandes</p>
    </a>
</div>

