<?php
// App/Views/Admin/layout.php - ADMIN PANEL LAYOUT
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - NovaShop Pro</title>
    <style>
        /* RESET */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { width: 100%; height: 100%; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif; background: #0a0e14; color: #d0d0d0; }
        
        /* HEADER */
        header { position: fixed; top: 0; left: 0; right: 0; width: 100%; height: 70px; background: linear-gradient(90deg, #1a2634 0%, #2d5a3d 100%); border-bottom: 3px solid #d4a574; z-index: 1000; display: flex; align-items: center; }
        header nav { width: 100%; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center; }
        .navbar-brand { font-size: 22px; font-weight: 800; color: #d4a574; }
        .nav-links { display: flex; gap: 12px; align-items: center; }
        .nav-links span { color: #999; font-size: 12px; }
        .nav-links a { padding: 8px 14px; border: 1px solid #d4a574; border-radius: 5px; color: #d4a574; text-decoration: none; font-size: 12px; font-weight: 600; transition: 0.2s; }
        .nav-links a:hover { background: #d4a574; color: #1a2634; }
        
        /* WRAPPER */
        .admin-wrapper { display: block; margin-top: 70px; min-height: calc(100vh - 70px); }
        
        /* SIDEBAR */
        aside { background: linear-gradient(180deg, #1a2634 0%, #162130 100%); border-right: 2px solid #d4a574; padding: 30px 0; position: fixed; width: 260px; height: calc(100vh - 70px); overflow-y: auto; top: 70px; left: 0; z-index: 100; }
        aside h2 { color: #d4a574; font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; padding: 0 20px; margin: 0 0 20px 0; }
        aside ul { list-style: none; }
        aside li { margin: 3px 0; }
        aside a { display: block; padding: 12px 20px; color: #888; text-decoration: none; border-left: 3px solid transparent; font-weight: 500; transition: 0.2s; }
        aside a:hover { background: rgba(212, 165, 116, 0.1); border-left-color: #d4a574; color: #d4a574; }
        aside a.active { background: rgba(212, 165, 116, 0.2); border-left-color: #d4a574; color: #d4a574; font-weight: 700; }
        
        /* MAIN */
        main { margin-left: 260px; padding: 40px; }
        h1 { color: #d4a574; font-size: 32px; margin: 0 0 30px 0; font-weight: 800; }
        h2 { color: #d4a574; font-size: 18px; margin: 25px 0 15px 0; font-weight: 700; }
        
        /* STATS */
        .admin-stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 40px; }
        .stat-card { background: linear-gradient(135deg, #1a2634 0%, #1e2a38 100%); border: 2px solid #d4a574; border-radius: 10px; padding: 20px; text-align: center; transition: 0.2s; }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 5px 20px rgba(212, 165, 116, 0.2); }
        .stat-label { color: #888; font-size: 11px; text-transform: uppercase; margin-bottom: 10px; }
        .stat-value { color: #d4a574; font-size: 32px; font-weight: 800; }
        
        /* FEATURE CARDS */
        .feature-card { background: linear-gradient(135deg, #1a2634 0%, #1e2a38 100%); border: 2px solid #d4a574; border-radius: 10px; padding: 25px; text-align: center; text-decoration: none; color: #d0d0d0; transition: 0.2s; }
        .feature-card:hover { transform: translateY(-3px); box-shadow: 0 5px 20px rgba(212, 165, 116, 0.2); }
        .feature-card h3 { color: #d4a574; margin: 0; font-size: 16px; }
        .feature-card p { color: #888; margin: 8px 0 0 0; font-size: 13px; }
        
        /* FORM */
        .admin-form { background: linear-gradient(135deg, #1a2634 0%, #1e2a38 100%); border: 2px solid #d4a574; border-radius: 10px; padding: 25px; margin: 25px 0; }
        .admin-form h2 { margin-top: 0; }
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; color: #d4a574; font-weight: 600; font-size: 11px; text-transform: uppercase; margin-bottom: 6px; }
        .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px 12px; background: rgba(15, 20, 25, 0.8); border: 1px solid #d4a574; border-radius: 5px; color: #d0d0d0; font-family: inherit; font-size: 13px; }
        .form-group input:focus, .form-group select:focus, .form-group textarea:focus { outline: none; border-color: #e8b788; box-shadow: 0 0 0 2px rgba(212, 165, 116, 0.1); }
        .form-group textarea { resize: vertical; min-height: 100px; }
        
        /* FORM GRID */
        .form-grid { display: grid !important; grid-template-columns: 1fr 1fr !important; gap: 20px !important; }
        
        /* BUTTONS */
        .btn { padding: 10px 18px; border: none; border-radius: 5px; font-weight: 600; cursor: pointer; transition: 0.2s; font-size: 12px; text-transform: uppercase; display: inline-block; text-decoration: none; }
        .btn-primary { background: linear-gradient(135deg, #d4a574 0%, #c59461 100%); color: #1a2634; width: 100%; }
        .btn-primary:hover { transform: translateY(-1px); box-shadow: 0 3px 10px rgba(212, 165, 116, 0.3); }
        .btn-danger { background: rgba(239, 68, 68, 0.2); color: #ef4444; border: 1px solid #ef4444; padding: 6px 12px; width: auto; }
        .btn-danger:hover { background: #ef4444; color: white; }
        .btn-info { background: rgba(59, 130, 246, 0.2); color: #3b82f6; border: 1px solid #3b82f6; padding: 6px 12px; width: auto; }
        .btn-info:hover { background: #3b82f6; color: white; }
        
        /* TABLE */
        .table-container { background: linear-gradient(135deg, #1a2634 0%, #1e2a38 100%); border: 2px solid #d4a574; border-radius: 10px; overflow: auto; margin: 25px 0; }
        table { width: 100%; border-collapse: collapse; }
        table thead { background: rgba(212, 165, 116, 0.1); border-bottom: 2px solid #d4a574; }
        table th { padding: 12px; text-align: left; color: #d4a574; font-weight: 700; font-size: 11px; text-transform: uppercase; }
        table td { padding: 12px; border-bottom: 1px solid rgba(212, 165, 116, 0.1); color: #888; font-size: 13px; }
        table tbody tr:hover { background: rgba(212, 165, 116, 0.05); }
        
        /* ALERT */
        .alert { padding: 12px 15px; border-radius: 5px; margin-bottom: 15px; border-left: 4px solid; font-size: 13px; }
        .alert-success { background: rgba(34, 197, 94, 0.1); color: #86efac; border-left-color: #22c55e; }
        .alert-danger { background: rgba(239, 68, 68, 0.1); color: #fca5a5; border-left-color: #ef4444; }
        .alert-info { background: rgba(59, 130, 246, 0.1); color: #93c5fd; border-left-color: #3b82f6; }
        
        @media (max-width: 1200px) {
            main { margin-left: 260px; padding: 30px; }
            .form-grid { grid-template-columns: 1fr 1fr !important; }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <span class="navbar-brand">🛍️ NovaShop Pro</span>
            <div class="nav-links">
                <span>Admin</span>
                <a href="/">🏠 Accueil</a>
                <a href="/logout" style="background: #ef4444; border-color: #ef4444; color: white;">Déconnexion</a>
            </div>
        </nav>
    </header>

    <div class="admin-wrapper">
        <aside>
            <h2>📊 Menu</h2>
            <ul>
                <li><a href="/admin/dashboard" class="<?php echo strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : ''; ?>">📊 Tableau de Bord</a></li>
                <li><a href="/admin/users" class="<?php echo strpos($_SERVER['REQUEST_URI'], 'users') !== false ? 'active' : ''; ?>">👥 Utilisateurs</a></li>
                <li><a href="/admin/products" class="<?php echo strpos($_SERVER['REQUEST_URI'], 'products') !== false ? 'active' : ''; ?>">📦 Produits</a></li>
                <li><a href="/admin/orders" class="<?php echo strpos($_SERVER['REQUEST_URI'], 'orders') !== false ? 'active' : ''; ?>">🛒 Commandes</a></li>
            </ul>
        </aside>

        <main>
            <?php echo $GLOBALS['admin_content'] ?? ''; ?>
        </main>
    </div>
</body>
</html>
