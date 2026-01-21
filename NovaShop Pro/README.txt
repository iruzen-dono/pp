# 🛍️ NovaShop Pro

Framework e-commerce MVC en PHP natif avec authentification, panier et gestion des commandes.

## 🚀 Démarrage rapide

### 1. Initialiser la BDD
```bash
mysql < setup.sql
```

### 2. Démarrer le serveur
```bash
cd Public && php -S localhost:8000
```

### 3. Accéder à l'application
```
http://localhost:8000
```

## ✨ Fonctionnalités

✅ **Authentification** - Inscription/Connexion sécurisée avec bcrypt  
✅ **Produits** - Catalogue avec catégories  
✅ **Panier** - Gestion en session  
✅ **Commandes** - Création et suivi  
✅ **Admin** - Dashboard avec middleware  
✅ **Sécurité** - Protection XSS, SQL injection, CSRF  

## 📂 Architecture MVC

```
Public/index.php
    ↓
App/Core/Router.php (parse URL)
    ↓
Controllers (logique métier)
    ↓
Models (base de données)
    ↓
Views (templates HTML)
```

## 🔌 Routes principales

| Route | Description |
|-------|-------------|
| `/` | Page d'accueil |
| `?url=auth/register` | Inscription |
| `?url=auth/login` | Connexion |
| `?url=products` | Catalogue |
| `?url=cart` | Panier |
| `?url=orders` | Mes commandes |
| `?url=admin/dashboard` | Admin (role required) |

## 📋 Pré-requis

- PHP 8.0+
- MySQL 5.7+
- Apache/Nginx (optionnel pour production)

## 📖 Documentation complète

- [DOCUMENTATION.md](DOCUMENTATION.md) - Guide complet
- [TESTS.md](TESTS.md) - Checklist de test
- [setup.sql](setup.sql) - Script de base de données

## 🧪 Diagnostic

Accédez au diagnostic système:
```
http://localhost:8000/diagnostic.php
```

## 🔒 Sécurité

✅ Hachage bcrypt des mots de passe  
✅ Prepared statements PDO  
✅ Protection XSS avec htmlspecialchars  
✅ Sessions sécurisées  
✅ Middleware d'authentification  

## 🐛 Problèmes courants

| Erreur | Solution |
|--------|----------|
| "Controller not found" | Vérifier l'URL (?url=controller/method) |
| Erreur BDD | Vérifier MySQL + credentials dans Database.php |
| Session vide | session_start() dans index.php |

## 📊 Structure de la BDD

**Users** - Authentification  
**Products** - Catalogue des produits  
**Categories** - Catégories  
**Orders** - Commandes  
**OrderItems** - Articles de commande  

## 💡 Prochains développements

- [ ] Panier persistant en BDD
- [ ] Système de paiement (Stripe)
- [ ] Notifications email
- [ ] Dashboard admin complet
- [ ] API REST
- [ ] Tests unitaires

## 📝 Licence

Projet personnel - Libre d'utilisation

---

**🎯 État: ✅ Production-ready** _(avec améliorations de sécurité recommandées)_

Pour plus de détails, consultez la [documentation complète](DOCUMENTATION.md).
