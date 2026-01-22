<div class="admin" style="max-width: 1000px; margin: 0 auto;">
    <h1>👨‍💼 Dashboard Administrateur</h1>
    <p class="subtitle">Gérez votre boutique NovaShop</p>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 30px 0;">
        <a href="/admin/users" style="text-decoration: none; display: block;">
            <div style="background: var(--secondary-color); border: 2px solid var(--border-color); border-radius: 8px; padding: 30px; text-align: center; transition: all 0.3s; cursor: pointer;">
                <div style="font-size: 48px; margin-bottom: 10px;">👥</div>
                <h3 style="color: var(--primary-color);">Utilisateurs</h3>
                <p style="color: #aaa; margin: 0;">Gérer les comptes</p>
            </div>
        </a>

        <a href="/admin/products" style="text-decoration: none; display: block;">
            <div style="background: var(--secondary-color); border: 2px solid var(--border-color); border-radius: 8px; padding: 30px; text-align: center; transition: all 0.3s; cursor: pointer;">
                <div style="font-size: 48px; margin-bottom: 10px;">📦</div>
                <h3 style="color: var(--primary-color);">Produits</h3>
                <p style="color: #aaa; margin: 0;">Gérer le catalogue</p>
            </div>
        </a>

        <a href="/admin/orders" style="text-decoration: none; display: block;">
            <div style="background: var(--secondary-color); border: 2px solid var(--border-color); border-radius: 8px; padding: 30px; text-align: center; transition: all 0.3s; cursor: pointer;">
                <div style="font-size: 48px; margin-bottom: 10px;">📋</div>
                <h3 style="color: var(--primary-color);">Commandes</h3>
                <p style="color: #aaa; margin: 0;">Voir les commandes</p>
            </div>
        </a>
    </div>

    <hr style="border: 1px solid var(--border-color); margin: 40px 0;">

    <h2>📊 Statistiques rapides</h2>
    <div style="background: var(--secondary-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 20px;">
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px;">
            <div style="text-align: center;">
                <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">UTILISATEURS</p>
                <p style="font-size: 28px; color: var(--primary-color); font-weight: bold;">—</p>
            </div>
            <div style="text-align: center;">
                <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">PRODUITS</p>
                <p style="font-size: 28px; color: var(--primary-color); font-weight: bold;">—</p>
            </div>
            <div style="text-align: center;">
                <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">COMMANDES</p>
                <p style="font-size: 28px; color: var(--primary-color); font-weight: bold;">—</p>
            </div>
        </div>
    </div>
</div>
