# 🌟 NovaShop Pro - E-Commerce Premium

Boutique en ligne premium avec **35 produits**, **vraies images**, et **interface admin exceptionnelle**.

## ⚡ Quick Start

### Windows (Recommandé)
```bash
# 1. Cloner
git clone <votre-repo>
cd NovaShop-Pro

# 2. Lancer le setup
double-cliquez sur: restart.bat
Choisissez: 1️⃣ SETUP COMPLET

# 3. Ouvrir
http://localhost:8000
```

### Linux/macOS
```bash
git clone <votre-repo>
cd NovaShop-Pro
chmod +x start.sh
./start.sh
```

## 📋 Prérequis

- ✅ PHP 8.0+
- ✅ MySQL 5.7+ / MariaDB 10.3+
- ✅ Windows 10+ / Linux / macOS

## 🎯 Fonctionnalités

### 🛒 Boutique Publique
- ✨ 35 produits premium
- 📸 Vraies images cohérentes
- 🔍 Recherche produits
- 🛍️ Panier et commandes
- 👤 Compte utilisateur
- ⭐ Interface moderne

### 🔐 Espace Admin
- 📊 Tableau de bord
- 📦 Gérer produits (Ajouter/Éditer/Supprimer)
- 📷 Upload images
- 👥 Gérer utilisateurs
- 🛒 Suivre commandes
- 💎 Design ultra-luxe

## 📁 Architecture

```
NovaShop-Pro/
├── restart.bat                    ← MAIN: Setup, restart, downloads
├── INSTALLATION.md                ← Guide complet
├── cleanup_temp_files.bat         ← Supprimer fichiers temp
│
├── Public/
│   ├── index.php
│   ├── Assets/
│   │   ├── Images/products/      ← 35 photos
│   │   ├── Css/Style.css
│   │   └── Js/
│
├── App/
│   ├── Controllers/
│   ├── Models/
│   ├── Views/
│   └── Core/
│
└── scripts/
```

## 🚀 Utilisation du restart.bat

### 1️⃣ SETUP COMPLET
```
👉 À utiliser après le clonage
   • Crée BD
   • Insère 35 produits
   • Télécharge images
```

### 2️⃣ RELANCER SERVEUR
```
👉 Redémarre PHP sans reset
   • Serveur à http://localhost:8000
```

### 3️⃣ RÉINITIALISER BD
```
👉 Reset données avec produits
   • BD recréée avec 35 produits
```

### 4️⃣ TÉLÉCHARGER IMAGES
```
👉 Récupère 35 photos produits
   • Via LoremFlickr
```

### 5️⃣ NETTOYER CACHE
```
👉 Instructions pour cache navigateur
   • Chrome/Firefox/Edge
```

### 6️⃣ RESET COMPLET
```
👉 Efface TOUT et recommence
   • ⚠️ Irréversible
```

## 👤 Comptes de Test

**Admin:**
- Email: `admin@novashop.local`
- Password: `admin123`
- Accès: http://localhost:8000/admin

**Client:**
- Email: `user@example.com`
- Password: `password123`

## 📦 35 Produits Premium

**Électronique (8):** Headphones, Smartphone, Laptop, SmartWatch, Tablet, Camera, Speaker, USB Hub

**Mode (8):** Leather Jacket, Sunglasses, Jeans, Dress, Sneakers, Sweater, T-Shirt, Scarf

**Livres (8):** Science, Programming, Art History, Cooking, Business, Fantasy, Photography, Design

**Maison (8):** Sofa, Dining Table, LED Lamp, Kitchen, Bed Frame, Wall Art, Outdoor Rug, Plant Pot

**Sports (3):** Mountain Bike, Yoga Mat, Running Shoes

## 🎨 Interface Admin

- 🌟 Design ultra-premium avec gradients
- 📏 Espaces généreux et confort maximal
- ✨ Animations fluides
- 📱 Responsive design
- ⚡ Performance optimale
- 🎯 UX intuitive

## 🔧 Développement

### Ajouter une page
```php
// 1. Controller
App/Controllers/MonController.php

// 2. Vue
App/Views/Mon/index.php

// 3. Route automatique
/mon → MonController@index()
```

### Modifier CSS/JS
- CSS: `Public/Assets/Css/Style.css`
- JS: `Public/Assets/Js/main.js`
- Actualiser: `Ctrl+Shift+R`

## 🐛 Troubleshooting

### MySQL introuvable
→ Installer MariaDB: https://mariadb.org/download

### Images ne s'affichent pas
→ Option 4️⃣ du restart.bat

### Port 8000 utilisé
→ `netstat -ano | findstr :8000` puis `taskkill /PID <ID> /F`

## 📖 Documentation Complète

Voir: **INSTALLATION.md** pour guide détaillé

## 🧹 Avant Déploiement

```bash
# Nettoyer fichiers temporaires
double-cliquez sur: cleanup_temp_files.bat
```

## 📝 Erreurs Corrigées

✅ CSS line-clamp compatibility
✅ AdminController image update
✅ Tous les validations PHP résolues

## 🎓 Stack Technique

- **Backend:** PHP 8.0+
- **BD:** MySQL 5.7 / MariaDB 10.3
- **Frontend:** HTML5, CSS3, JavaScript
- **Architecture:** MVC Pattern
- **Server:** PHP Built-in / Apache / Nginx

## 🌐 Déploiement

1. Uploader sur serveur avec PHP 8.0+
2. Configurer BD MySQL
3. Exécuter: `php start_novashop.php`
4. Configurez serveur web

## 📞 Support

**Besoin d'aide?**
1. Lire: INSTALLATION.md
2. Utiliser: Option 5️⃣ du restart.bat
3. Vérifier: logs si erreur

## 📄 Licence

Privé - Projet NovaShop Pro

---

**Créé avec ❤️ | NovaShop Pro 2026**

**Contact:** Voir config git
