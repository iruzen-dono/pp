# 🚀 Installation Complète NovaShop Pro - Guide Automatisé

## ⚡ Démarrage Rapide (5 minutes)

### Étape 1: Installation des Dépendances

**Double-cliquez sur:** `install_dependencies.bat`

Ce script vérifie et installe automatiquement:
- ✅ PHP 8.2
- ✅ MariaDB (avec MySQL client)
- ✅ Configuration du PATH Windows

### Étape 2: Utiliser restart.bat

**Double-cliquez sur:** `restart.bat`

Ensuite, choisissez l'option souhaitée dans le menu.

---

## 📋 Options disponibles dans restart.bat

### 1️⃣ SETUP COMPLET (Installation initiale)
**Pour qui?** Première installation après clonage du projet

**Ce qu'il fait:**
- Crée la base de données 'novashop'
- Crée 5 tables: users, categories, products, orders, order_items
- Insère 35 produits premium
- Télécharge les images produits (35 photos)
- Démarre le serveur

**Durée:** ~2-3 minutes

### 2️⃣ RELANCER SERVEUR (Sans reset)
**Pour qui?** Redémarrer l'application existante

**Ce qu'il fait:**
- Démarre le serveur PHP
- Conserve toutes les données
- Conserve tous les utilisateurs

**Durée:** Immédiat

### 3️⃣ RÉINITIALISER BD (Reset données)
**Pour qui?** Remettre à zéro tout en gardant l'application

**Ce qu'il fait:**
- Supprime la base de données
- Recréé les tables
- Réinsère 35 produits
- Réinsère 6 utilisateurs de test

**Durée:** ~1 minute

### 4️⃣ TÉLÉCHARGER IMAGES (35 photos)
**Pour qui?** Récupérer les images des produits

**Ce qu'il fait:**
- Télécharge 35 images depuis LoremFlickr
- Les sauvegarde dans: `Public/Assets/Images/products/`

**Durée:** ~30 secondes

### 5️⃣ NETTOYER CACHE NAVIGATEUR (Instructions)
**Pour qui?** Résoudre les problèmes d'affichage

**Instructions:**
- Ouvrez http://localhost:8000
- Appuyez sur F12 (DevTools)
- Allez dans: Application → Storage
- Cliquez: Clear Site Data
- Appuyez sur Ctrl+Shift+R (hard refresh)

### 6️⃣ RESET COMPLET (Tout effacer)
**Pour qui?** Recommencer complètement à zéro

**Ce qu'il fait:**
- Supprime la base de données
- Supprime les images téléchargées
- Recréé un système vierge
- Réinsère 35 produits premium

**Durée:** ~1 minute

---

## 🔐 Identifiants par défaut

### Admin
```
Email: admin@novashop.local
Mot de passe: admin123
```

### Utilisateurs de test
```
1. user1@test.local / password1
2. user2@test.local / password2
3. user3@test.local / password3
4. user4@test.local / password4
5. user5@test.local / password5
6. user6@test.local / password6
```

---

## 🌐 Accès à l'application

Une fois le serveur lancé, ouvrez:
```
http://localhost:8000
```

**Port par défaut:** 8000  
**Adresse:** http://localhost:8000

---

## 🆘 Dépannage

### Erreur: "php is not recognized"
```
Solution: Installez PHP avec install_dependencies.bat
```

### Erreur: "MySQL/MariaDB not found"
```
Solution: Installez MariaDB avec install_dependencies.bat
```

### Erreur: "Access denied for user 'root'@'localhost'"
```
Solution: 
1. Ouvrez une invite de commandes
2. Exécutez: mysql -u root
3. Tapez votre mot de passe (par défaut: root)
4. Si cela fonctionne, MariaDB est bien configuré
```

### Images ne s'affichent pas
```
Solution:
1. Exécutez l'option 4 (Télécharger images)
2. Nettoyez le cache navigateur (option 5)
3. Appuyez sur Ctrl+Shift+R
```

### Problèmes de connexion en base
```
Solution:
1. Vérifiez que MariaDB est démarré:
   - Windows: Services → Cherchez "MariaDB" → Vérifiez que c'est en cours d'exécution
2. Redémarrez MariaDB si nécessaire
3. Essayez l'option 3 (Réinitialiser BD)
```

---

## 📂 Structure du projet

```
NovaShop Pro/
├── install_dependencies.bat      ← Installation dépendances
├── restart.bat                   ← Menu principal
├── start_novashop.php            ← Script d'initialisation
├── Public/
│   ├── index.php                 ← Point d'entrée
│   ├── router.php                ← Routeur
│   └── Assets/
│       └── Images/
│           └── products/         ← Images téléchargées ici
├── App/
│   ├── Controllers/              ← Contrôleurs
│   ├── Models/                   ← Modèles BD
│   └── Views/                    ← Templates HTML
└── scripts/
    └── *.sql                     ← Scripts SQL
```

---

## ✅ Checklist d'installation

- [ ] Installer les dépendances (install_dependencies.bat)
- [ ] Exécuter restart.bat
- [ ] Choisir option 1 (SETUP COMPLET)
- [ ] Vérifier que le serveur est en ligne
- [ ] Accéder à http://localhost:8000
- [ ] Se connecter avec admin@novashop.local / admin123
- [ ] Tester les fonctionnalités

---

## 🔗 Ressources utiles

- **PHP:** https://www.php.net/downloads
- **MariaDB:** https://mariadb.org/download/
- **Documentation NovaShop Pro:** README_FINAL.md

---

**Besoin d'aide?** Consultez les fichiers:
- `INSTALLATION.md`
- `README_FINAL.md`
- `STATUS.sh`
