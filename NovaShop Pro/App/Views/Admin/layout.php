<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - NovaShop Pro</title>
    <style>
        /* ===== RESET & BASE ===== */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        
        body { 
            font-family: 'Segoe UI', 'Roboto', -apple-system, BlinkMacSystemFont, sans-serif;
            background: linear-gradient(135deg, #0a1120 0%, #151d35 50%, #0a1120 100%);
            color: #e0e0e0;
            min-height: 100vh;
            position: relative;
        }

        /* Effet de fond animé */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(ellipse 80% 80% at 50% 20%, rgba(212, 165, 116, 0.08) 0%, transparent 50%);
            pointer-events: none;
            z-index: 1;
        }

        /* ===== HEADER PREMIUM ===== */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            height: 90px;
            background: linear-gradient(90deg, rgba(10, 17, 32, 0.97) 0%, rgba(21, 29, 53, 0.97) 100%);
            backdrop-filter: blur(20px);
            border-bottom: 2px solid rgba(212, 165, 116, 0.25);
            z-index: 1000;
            display: flex;
            align-items: center;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.4);
        }

        header nav {
            width: 100%;
            padding: 0 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-brand {
            font-size: 28px;
            font-weight: 900;
            background: linear-gradient(135deg, #d4a574 0%, #e8b788 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
        }

        .nav-links {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .nav-links span {
            color: #999;
            font-size: 14px;
            font-weight: 500;
            letter-spacing: 0.5px;
        }

        .nav-links a {
            padding: 12px 24px;
            border-radius: 10px;
            color: #d4a574;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            border: 2px solid rgba(212, 165, 116, 0.5);
            background: rgba(212, 165, 116, 0.08);
        }

        .nav-links a:hover {
            background: linear-gradient(135deg, #d4a574 0%, #c99463 100%);
            color: #0a1120;
            border-color: #d4a574;
            transform: translateY(-3px);
            box-shadow: 0 12px 24px rgba(212, 165, 116, 0.35);
        }

        /* ===== WRAPPER ===== */
        .admin-wrapper {
            display: flex;
            margin-top: 90px;
            min-height: calc(100vh - 90px);
            position: relative;
            z-index: 2;
        }

        /* ===== SIDEBAR LUXE ===== */
        aside {
            width: 320px;
            background: linear-gradient(180deg, rgba(10, 17, 32, 0.9) 0%, rgba(15, 23, 45, 0.9) 100%);
            backdrop-filter: blur(20px);
            border-right: 2px solid rgba(212, 165, 116, 0.2);
            padding: 50px 0;
            position: fixed;
            height: calc(100vh - 90px);
            overflow-y: auto;
            top: 90px;
            left: 0;
            z-index: 100;
            box-shadow: 8px 0 32px rgba(0, 0, 0, 0.4);
        }

        aside::-webkit-scrollbar {
            width: 8px;
        }

        aside::-webkit-scrollbar-track {
            background: transparent;
        }

        aside::-webkit-scrollbar-thumb {
            background: rgba(212, 165, 116, 0.4);
            border-radius: 4px;
        }

        aside::-webkit-scrollbar-thumb:hover {
            background: rgba(212, 165, 116, 0.6);
        }

        aside h2 {
            color: rgba(212, 165, 116, 0.8);
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 2px;
            padding: 0 35px;
            margin: 0 0 40px 0;
        }

        aside ul {
            list-style: none;
        }

        aside li {
            margin: 12px 0;
        }

        aside a {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 18px 35px;
            color: #999;
            text-decoration: none;
            border-left: 4px solid transparent;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s ease;
            position: relative;
        }

        aside a:hover {
            color: #d4a574;
            background: rgba(212, 165, 116, 0.1);
            border-left-color: #d4a574;
            padding-left: 42px;
        }

        aside a.active {
            color: #d4a574;
            background: linear-gradient(90deg, rgba(212, 165, 116, 0.2) 0%, rgba(212, 165, 116, 0.08) 100%);
            border-left-color: #d4a574;
            font-weight: 700;
            box-shadow: inset 0 0 20px rgba(212, 165, 116, 0.1);
        }

        /* ===== MAIN CONTENT ===== */
        main {
            margin-left: 320px;
            padding: 60px 70px;
            width: calc(100% - 320px);
            background: linear-gradient(135deg, rgba(10, 17, 32, 0.4) 0%, rgba(21, 29, 53, 0.2) 100%);
        }

        main::-webkit-scrollbar {
            width: 12px;
        }

        main::-webkit-scrollbar-track {
            background: transparent;
        }

        main::-webkit-scrollbar-thumb {
            background: rgba(212, 165, 116, 0.4);
            border-radius: 6px;
        }

        main::-webkit-scrollbar-thumb:hover {
            background: rgba(212, 165, 116, 0.6);
        }

        /* ===== TYPOGRAPHIE ===== */
        h1 {
            color: #d4a574;
            font-size: 48px;
            margin: 0 0 50px 0;
            font-weight: 800;
            letter-spacing: -1.5px;
        }

        h2 {
            color: #d4a574;
            font-size: 24px;
            margin: 60px 0 30px 0;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        h3 {
            color: #d4a574;
            font-size: 18px;
            font-weight: 600;
        }

        /* ===== STATS CARDS LUXE ===== */
        .admin-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 40px;
            margin-bottom: 60px;
        }

        .stat-card {
            background: linear-gradient(135deg, rgba(212, 165, 116, 0.12) 0%, rgba(212, 165, 116, 0.06) 100%);
            border: 2px solid rgba(212, 165, 116, 0.3);
            border-radius: 20px;
            padding: 50px 40px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(212, 165, 116, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .stat-card:hover {
            transform: translateY(-12px);
            border-color: #d4a574;
            box-shadow: 0 24px 56px rgba(212, 165, 116, 0.25);
            background: linear-gradient(135deg, rgba(212, 165, 116, 0.18) 0%, rgba(212, 165, 116, 0.1) 100%);
        }

        .stat-card:hover::before {
            left: 100%;
        }

        .stat-label {
            color: #999;
            font-size: 13px;
            text-transform: uppercase;
            margin-bottom: 20px;
            letter-spacing: 1.5px;
            font-weight: 600;
        }

        .stat-value {
            color: #d4a574;
            font-size: 56px;
            font-weight: 900;
            letter-spacing: -2px;
        }

        /* ===== FORMS ===== */
        .admin-form {
            background: linear-gradient(135deg, rgba(212, 165, 116, 0.1) 0%, rgba(212, 165, 116, 0.04) 100%);
            border: 2px solid rgba(212, 165, 116, 0.25);
            border-radius: 20px;
            padding: 50px;
            margin: 40px 0;
            backdrop-filter: blur(10px);
        }

        .admin-form h2 {
            margin-top: 0;
            margin-bottom: 40px;
        }

        .form-group {
            margin-bottom: 32px;
        }

        .form-group label {
            display: block;
            color: #d4a574;
            font-weight: 600;
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 14px;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 16px 20px;
            background: rgba(10, 17, 32, 0.7);
            border: 2px solid rgba(212, 165, 116, 0.3);
            border-radius: 12px;
            color: #e0e0e0;
            font-family: inherit;
            font-size: 15px;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #d4a574;
            background: rgba(10, 17, 32, 0.9);
            box-shadow: 0 0 0 4px rgba(212, 165, 116, 0.15);
        }

        .form-group textarea {
            resize: vertical;
            min-height: 150px;
        }

        .form-grid {
            display: grid !important;
            grid-template-columns: 1fr 1fr !important;
            gap: 32px !important;
        }

        /* ===== BUTTONS ===== */
        .btn {
            padding: 14px 32px;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
            font-size: 14px;
            text-transform: uppercase;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            letter-spacing: 0.8px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #d4a574 0%, #e8b788 100%);
            color: #0a1120;
            width: 100%;
            box-shadow: 0 12px 32px rgba(212, 165, 116, 0.35);
        }

        .btn-primary:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 48px rgba(212, 165, 116, 0.45);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: rgba(212, 165, 116, 0.15);
            color: #d4a574;
            border: 2px solid rgba(212, 165, 116, 0.4);
        }

        .btn-secondary:hover {
            background: rgba(212, 165, 116, 0.25);
            border-color: #d4a574;
            transform: translateY(-2px);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 10px 20px;
            width: auto;
            font-size: 13px;
            box-shadow: 0 6px 16px rgba(245, 158, 11, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(245, 158, 11, 0.4);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
            padding: 10px 20px;
            width: auto;
            font-size: 13px;
            box-shadow: 0 6px 16px rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(239, 68, 68, 0.4);
        }

        /* ===== TABLES LUXE ===== */
        .table-container {
            background: linear-gradient(135deg, rgba(212, 165, 116, 0.1) 0%, rgba(212, 165, 116, 0.04) 100%);
            border: 2px solid rgba(212, 165, 116, 0.25);
            border-radius: 20px;
            overflow: hidden;
            margin: 40px 0;
            box-shadow: 0 16px 56px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table thead {
            background: linear-gradient(90deg, rgba(212, 165, 116, 0.18) 0%, rgba(212, 165, 116, 0.1) 100%);
            border-bottom: 2px solid rgba(212, 165, 116, 0.3);
        }

        table th {
            padding: 24px 28px;
            text-align: left;
            color: #d4a574;
            font-weight: 700;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.8px;
        }

        table td {
            padding: 24px 28px;
            border-bottom: 1px solid rgba(212, 165, 116, 0.12);
            color: #d0d0d0;
            font-size: 14px;
        }

        table tbody tr {
            transition: all 0.3s ease;
        }

        table tbody tr:hover {
            background: rgba(212, 165, 116, 0.1);
        }

        table tbody tr:last-child td {
            border-bottom: none;
        }

        /* ===== ALERTS ===== */
        .alert {
            padding: 24px 28px;
            border-radius: 14px;
            margin-bottom: 28px;
            border-left: 5px solid;
            font-size: 15px;
            display: flex;
            align-items: center;
            gap: 16px;
            backdrop-filter: blur(10px);
            animation: slideDown 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.18) 0%, rgba(34, 197, 94, 0.08) 100%);
            color: #86efac;
            border-left-color: #22c55e;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.18) 0%, rgba(239, 68, 68, 0.08) 100%);
            color: #fca5a5;
            border-left-color: #ef4444;
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.18) 0%, rgba(59, 130, 246, 0.08) 100%);
            color: #93c5fd;
            border-left-color: #3b82f6;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 1600px) {
            main {
                padding: 50px 50px;
            }

            h1 {
                font-size: 40px;
            }

            .stat-value {
                font-size: 48px;
            }
        }

        @media (max-width: 1200px) {
            aside {
                width: 280px;
            }

            main {
                margin-left: 280px;
                width: calc(100% - 280px);
                padding: 40px 40px;
            }

            .admin-stats {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .form-grid {
                grid-template-columns: 1fr !important;
            }

            h1 {
                font-size: 36px;
                margin-bottom: 35px;
            }
        }

        @media (max-width: 768px) {
            header {
                height: 70px;
            }

            header nav {
                padding: 0 20px;
            }

            .navbar-brand {
                font-size: 20px;
            }

            .nav-links {
                gap: 12px;
            }

            .nav-links a {
                padding: 8px 14px;
                font-size: 12px;
            }

            .admin-wrapper {
                margin-top: 70px;
                flex-direction: column;
            }

            aside {
                width: 100%;
                height: auto;
                position: relative;
                top: auto;
                border-right: none;
                border-bottom: 2px solid rgba(212, 165, 116, 0.2);
                padding: 25px;
            }

            main {
                margin-left: 0;
                width: 100%;
                padding: 25px;
            }

            h1 {
                font-size: 28px;
                margin-bottom: 25px;
            }

            .admin-form {
                padding: 30px;
            }

            .stat-card {
                padding: 30px 25px;
            }

            .stat-value {
                font-size: 36px;
            }

            table th,
            table td {
                padding: 14px 12px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <span class="navbar-brand">✨ NovaShop Admin</span>
            <div class="nav-links">
                <span>Bienvenue Admin</span>
                <a href="/">🏠 Accueil</a>
                <a href="/logout" style="background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); border-color: #ef4444; color: white; box-shadow: 0 8px 16px rgba(239, 68, 68, 0.35);">🚪 Déconnexion</a>
            </div>
        </nav>
    </header>

    <div class="admin-wrapper">
        <aside>
            <h2>📊 Navigation</h2>
            <ul>
                <li>
                    <a href="/admin/dashboard" class="<?php echo strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active' : ''; ?>">
                        <span>📊</span> Tableau de Bord
                    </a>
                </li>
                <li>
                    <a href="/admin/users" class="<?php echo strpos($_SERVER['REQUEST_URI'], 'users') !== false ? 'active' : ''; ?>">
                        <span>👥</span> Utilisateurs
                    </a>
                </li>
                <li>
                    <a href="/admin/products" class="<?php echo strpos($_SERVER['REQUEST_URI'], 'products') !== false ? 'active' : ''; ?>">
                        <span>📦</span> Produits
                    </a>
                </li>
                <li>
                    <a href="/admin/orders" class="<?php echo strpos($_SERVER['REQUEST_URI'], 'orders') !== false ? 'active' : ''; ?>">
                        <span>🛒</span> Commandes
                    </a>
                </li>
            </ul>
        </aside>

        <main>
            <?php echo $GLOBALS['admin_content'] ?? ''; ?>
        </main>
    </div>
</body>
</html>
