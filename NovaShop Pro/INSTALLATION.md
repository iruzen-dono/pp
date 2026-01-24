# 🚀 NovaShop Pro - Guide d'Installation Complet

> Boutique e-commerce premium avec 35 produits et vraies images

## 📋 Prérequis

**Logiciels obligatoires:**
- ✅ PHP 8.0+ (avec extensions: mysqli, pdo)
- ✅ MySQL 5.7+ ou MariaDB 10.3+
- ✅ Git (pour cloner le dépôt)
- ✅ Windows 10+ / Linux / macOS

## 🎯 Installation Rapide (3 étapes)

### Étape 1: Cloner le dépôt
```bash
git clone https://github.com/votre-username/novashop-pro.git
cd novashop-pro
```

### Étape 2: Lancer le setup
**Windows:**
```bash
double-cliquez sur: restart.bat
Choisissez l'option: 1️⃣  SETUP COMPLET
```

**Linux/macOS:**
```bash
chmod +x start.sh
./start.sh
```

### Étape 3: Ouvrir la boutique
```
🌐 http://localhost:8000
```

**Admin:**
- Email: `admin@novashop.local`
- Password: `admin123`

---

## 📖 Guide Détaillé - restart.bat

Le fichier `restart.bat` (Windows) contient 6 options:

### 1️⃣ SETUP COMPLET (Installation initiale)
Pour la **première fois** après clonage:
- ✅ Crée la BD `novashop` de zéro
- ✅ Insère 35 produits premium
- ✅ Télécharge 35 photos produits
- ✅ Lance le serveur automatiquement

```
Utilisez cette option si: Vous avez cloné le dépôt
Durée: 2-3 minutes
```

### 2️⃣ RELANCER SERVEUR
Redémarre le serveur PHP sans toucher aux données:
- 🔄 Serveur redémarré
- 📊 Données conservées
- ⚡ Parfait après avoir arrêté le serveur

```
Utilisez cette option si: Vous avez arrêté le serveur avec Ctrl+C
Durée: 10 secondes
```

### 3️⃣ RÉINITIALISER BD
Récréé la BD avec les 35 produits:
- 🗑️ BD supprimée et recréée
- 📦 35 produits réinsérés
- 👥 6 utilisateurs de test restaurés

```
Utilisez cette option si: Vous avez modifié les données et voulez les reset
Durée: 30 secondes
Confirmation: Tapez O
```

### 4️⃣ TÉLÉCHARGER IMAGES
Télécharge les 35 photos des produits:
- 📥 Images depuis LoremFlickr (service cloud)
- 💾 Stockées localement dans: `Public/Assets/Images/products/`
- 🔄 Skipe automatiquement les images existantes

```
Utilisez cette option si: Les images ne s'affichent pas / Vous les avez supprimées
Durée: 2-5 minutes (dépend de votre connexion)
```

### 5️⃣ NETTOYER CACHE NAVIGATEUR
Instructions détaillées pour nettoyer le cache:
- Chrome/Edge/Firefox: F12 → Application → Clear All
- Ou: Ctrl+Shift+Delete
- Puis: Ctrl+Shift+R (hard refresh)

```
Utilisez cette option si: CSS/JS ne se met pas à jour / Le site affiche du contenu ancien
```

### 6️⃣ RESET COMPLET
Efface TOUT et recommence de zéro:
- 🗑️ BD supprimée
- 📷 Images supprimées
- 📦 Recréé avec 35 produits
- ⚠️ Les modifications personnelles seront perdues

```
Utilisez cette option si: Vous avez tout cassé / Voulez recommencer
Durée: 3-5 minutes
Confirmation: Tapez OUI (en majuscules)
```

---

## 🔧 Structure du Projet

```
novashop-pro/
├── 📄 restart.bat              ← À exécuter pour setup/restart
├── 📄 start.sh                 ← Pour Linux/macOS
├── 📄 start_novashop.php       ← Initialisation BD
│
├── Public/
│   ├── index.php               ← Point d'entrée
│   ├── router.php              ← Routeur
│   └── Assets/
│       └── Images/
│           ├── products/       ← Photos produits (35)
│           ├── download_images.php  ← Télécharge les photos
│           └── Css/, Js/
│
├── App/
│   ├── Controllers/            ← Logique app
│   ├── Models/                 ← BD models
│   ├── Views/                  ← Templates HTML
│   └── Core/                   ← Framework
│
└── scripts/
    ├── create_admin.php
    └── db_inspect.php
```

---

## 🐛 Troubleshooting

### ❌ "MySQL/MariaDB introuvable"
**Solution:**
1. Installer MariaDB: https://mariadb.org/download
2. Ou MySQL: https://dev.mysql.com/downloads/mysql/
3. Installer dans: `C:\Program Files\MariaDB` (chemin standard)
4. Redémarrer l'ordinateur

### ❌ "Port 8000 déjà utilisé"
**Solution:**
```bash
# Vérifier qui utilise le port
netstat -ano | findstr :8000

# Tuer le processus (remplacer PID par le numéro)
taskkill /PID 12345 /F

# Puis relancer restart.bat
```

### ❌ Les images ne s'affichent pas
**Solutions:**
1. Utiliser l'option **4️⃣ TÉLÉCHARGER IMAGES** du restart.bat
2. Vérifier: `Public/Assets/Images/products/` (doit avoir 35 fichiers)
3. Nettoyer cache: Ctrl+Shift+Delete + Ctrl+Shift+R

### ❌ "Erreur de connexion BD"
**Solutions:**
1. Vérifier que MySQL/MariaDB est démarré:
   - Windows: Services.msc → MariaDB (ou MySQL) → Vérifier status
   - Linux: `sudo systemctl status mysql`
2. Vérifier les identifiants dans `start_novashop.php`

### ❌ "Erreur: Unknown database 'novashop'"
**Solution:**
Utiliser l'option **3️⃣ RÉINITIALISER BD** pour recréer la BD

---

## 🎓 Guide Admin

### Accès Admin
1. Allez sur: http://localhost:8000/login
2. Email: `admin@novashop.local`
3. Mot de passe: `admin123`
4. Tableau de bord: http://localhost:8000/admin

### Gérer les Produits
1. **Ajouter:** Admin → Produits → Formulaire
2. **Éditer:** Cliquez sur ✏️ à côté du produit
3. **Supprimer:** Cliquez sur 🗑️
4. **Upload image:** Formats acceptés: JPG, PNG, WebP, GIF (max 5MB)

### Gérer les Utilisateurs
1. Admin → Utilisateurs
2. Ajouter, éditer ou supprimer des comptes

### Voir les Commandes
1. Admin → Commandes
2. Consulter toutes les commandes clients

---

## 📦 35 Produits Premium

La BD est pré-remplie avec 35 produits réalistes:

**Électronique (8):** Headphones, Smartphone, Laptop, SmartWatch, Tablet, Camera, Speaker, USB Hub

**Mode (8):** Leather Jacket, Sunglasses, Jeans, Dress, Sneakers, Sweater, T-Shirt, Scarf

**Livres (8):** Science, Programming, Art History, Cooking, Business, Fantasy, Photography, Design

**Maison (8):** Sofa, Dining Table, LED Lamp, Kitchen, Bed Frame, Wall Art, Outdoor Rug, Plant Pot

**Sports (3):** Mountain Bike, Yoga Mat, Running Shoes

---

## 🛠️ Développement Local

### Modifier le code
Les fichiers sont en temps réel - pas besoin de redémarrer le serveur

### Ajouter une page
1. Créer contrôleur: `App/Controllers/MonController.php`
2. Créer vue: `App/Views/Mon/index.php`
3. Route automatique: `/mon` → `MonController@index()`

### Éditer CSS/JS
- CSS: `Public/Assets/Css/Style.css`
- JS: `Public/Assets/Js/main.js`
- Actualiser: Ctrl+Shift+R

---

## 📝 Identifiants de Test

**Comptes clients:**
- Email: `user@example.com` | Mot de passe: `password123`
- Email: `test@novashop.local` | Mot de passe: `password123`

**Compte admin:**
- Email: `admin@novashop.local` | Mot de passe: `admin123`

---

## 🚀 Déploiement en Production

1. Déplacer le dossier sur un serveur avec PHP 8.0+
2. Configurer la BD MySQL/MariaDB
3. Exécuter: `php start_novashop.php` (une fois)
4. Serveur web: Apache, Nginx ou PHP built-in

---

## 📞 Support

**Besoin d'aide?**
- Vérifier ce guide
- Utiliser l'option 5️⃣ du restart.bat pour les erreurs courantes
- Vérifier les logs: `Public/` (si fichier error_log existe)

---

**Créé avec ❤️ pour NovaShop Pro**
