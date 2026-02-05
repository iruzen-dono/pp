# 🚀 NovaShop PRO - Guide de Démarrage

## 📋 Prérequis
- PHP 7.4+ (testé sur PHP 8.x)
- MySQL 5.7+
- Composer (optionnel)

## ⚙️ Installation

### 1️⃣ Setup Initial
```bash
# Windows - Double-cliquez sur START_SERVER.bat
# OU Mac/Linux
cd NovaShop\ Pro
php -S localhost:8000 -t Public Public/router.php
```

### 2️⃣ Configuration Base de Données
```bash
# Éditer App/Config/env.php avec vos identifiants MySQL
nano App/Config/env.php
```

**Variables à configurer:**
```php
'db_host' => 'localhost',
'db_name' => 'novashop',
'db_user' => 'root',
'db_pass' => '',  // Your MySQL password
```

### 3️⃣ Initialisation BD
```bash
# Option A: Via script PHP
php scripts/seed_complete_data.php

# Option B: Manuellement
mysql -u root -p novashop < setup.sql
mysql -u root -p novashop < migrate_email_verification.sql
```

### 4️⃣ Créer Super Admin
```bash
cd scripts
php promote_to_super_admin.php 1    # Promeut user ID 1 en super_admin
```

### 5️⃣ Lancer le Serveur

**Windows:**
```bash
double-cliquez START_SERVER.bat
```

**Mac/Linux:**
```bash
php -S localhost:8000 -t Public public/router.php
```

✅ Site accessible: `http://localhost:8000`

---

## 👥 Comptes de Test

Après initialisation, comptes disponibles:

| Email | Password | Rôle |
|-------|----------|------|
| admin@novashop.local | admin | super_admin |
| user@test.local | password123 | user |

---

## 📁 Structure

```
NovaShop Pro/
├── App/                    # Code applicatif
│   ├── Config/            # Configuration
│   ├── controllers/        # Contrôleurs MVC
│   ├── Models/            # Modèles BD
│   ├── middleware/        # Middleware (Auth, CSRF)
│   ├── Services/          # Logique métier
│   └── Views/             # Templates PHP
├── Public/                # Assets publics
│   ├── index.php          # Entrée app
│   ├── router.php         # Router personnalisé
│   └── Assets/
│       ├── Css/           # Feuilles de style
│       ├── Js/            # JavaScript
│       └── Images/        # Images
├── scripts/               # Scripts administratifs
│   ├── migrate_*.php      # Migrations BD
│   ├── promote_to_super_admin.php
│   └── seed_complete_data.php
├── docs/                  # Documentation
├── START_SERVER.bat       # Lancer serveur (Windows)
└── setup.sql             # SQL d'initialisation
```

---

## 🔐 Sécurité

✅ Protections implémentées:
- **BCRYPT** - Hashage des passwords
- **Prepared Statements** - Protection SQL Injection
- **CSRF Tokens** - Protection CSRF
- **htmlspecialchars()** - Protection XSS
- **Session Regeneration** - Prévention session hijacking
- **Role-based Access Control** - Contrôle d'accès

---

## 📊 Fonctionnalités Principales

✅ **Authentification** - Registration, Login, Reset Password  
✅ **Panier** - Ajout/Suppression produits  
✅ **Produits** - Catalogue avec recherche et filtres  
✅ **Commandes** - Historique et statut suivi  
✅ **Panel Admin** - Gestion complets (Users, Produits, Commandes)  

---

## 🆘 Troubleshooting

**"Site not found"?**
→ Vérifier que PHP est en cours d'exécution sur port 8000

**"Database connection error"?**
→ Vérifier env.php et que MySQL est en cours d'exécution

**"Blank page"?**
→ Vérifier les logs PHP ou activer error_reporting dans App/Config/Database.php

---

## 📚 Documentation Complète

- **RAPPORT_PROJET.md** - Architecture & spécifications
- **GUIDE_UTILISATION.md** - Tutoriaux utilisateurs
- **DOCUMENT_TECHNIQUE.md** - Questions pour prof

---

**Version:** 1.0  
**Dernière mise à jour:** Février 2026  
**Statut:** ✅ Production-ready
