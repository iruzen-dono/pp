# NovaShop Pro - Ressources d'Installation pour Nouveau PC

Ce fichier contient toutes les ressources et instructions pour installer NovaShop Pro sur un nouveau PC.

## 📦 Ce qui est inclus dans ce dossier

### Scripts d'installation automatisés
- **`setup_auto.bat`** - Installation automatique des dépendances (PHP + MariaDB)
- **`install_dependencies.bat`** - Alternative manuelle pour installer les dépendances
- **`restart.bat`** - Menu principal pour gérer l'application

### Guides de documentation
- **`QUICKSTART.md`** - Guide de démarrage rapide (3 étapes)
- **`SETUP_GUIDE.md`** - Guide complet avec toutes les options
- **`INSTALLATION.md`** - Documentation technique détaillée
- **`README_FINAL.md`** - Manuel d'utilisation complet
- **`README.md`** - Information générale sur le projet

### Scripts SQL (base de données)
- **`setup.sql`** - Création de base initiale
- **`seed.sql`** - Données de test
- **`seed_premium.sql`** - 35 produits premium
- **`renumber_products.sql`** - Utilitaire
- **`renumber_orders.sql`** - Utilitaire
- **`update_passwords.sql`** - Utilitaire

### Autres fichiers utiles
- **`start_novashop.php`** - Script d'initialisation PHP
- **`router.php`** - Routeur de l'application
- **`cleanup_temp_files.bat`** - Nettoyage des fichiers temporaires
- **`STATUS.sh`** - Script de diagnostic

---

## 🚀 Installation Rapide (Nouveau PC)

### Étape 1: Vérifier la configuration
Assurez-vous d'avoir:
- ✅ Windows 7+ ou Windows Server 2008+
- ✅ Accès administrateur
- ✅ Internet (pour PHP et MariaDB)

### Étape 2: Exécuter l'installation automatique
```
Clic droit sur setup_auto.bat
→ "Exécuter en tant qu'administrateur"
```

Suivez les instructions. Le script:
1. Détecte les dépendances existantes
2. Propose de télécharger PHP 8.2 (si nécessaire)
3. Propose de télécharger MariaDB (si nécessaire)
4. Configure le PATH Windows automatiquement

### Étape 3: Lancer l'application
```
Double-cliquez sur restart.bat
→ Choisissez l'option 1 (SETUP COMPLET)
```

### Étape 4: Accéder à l'application
Ouvrez votre navigateur et allez à:
```
http://localhost:8000
```

---

## 🎯 Menu de restart.bat (6 Options)

### 1️⃣ SETUP COMPLET
- Pour une première installation
- Crée la BD, insère 35 produits premium, télécharge les images
- **Durée:** ~2-3 minutes

### 2️⃣ RELANCER SERVEUR  
- Redémarre juste le serveur
- Conserve toutes les données
- **Durée:** Immédiat

### 3️⃣ RÉINITIALISER BD
- Reset de la BD avec 35 produits
- Conserve l'application
- **Durée:** ~1 minute

### 4️⃣ TÉLÉCHARGER IMAGES
- Récupère 35 images de produits
- Stocke dans Public/Assets/Images/products/
- **Durée:** ~30 secondes

### 5️⃣ NETTOYER CACHE
- Instructions pour nettoyer le cache navigateur
- Aide si le site ne s'affiche pas correctement

### 6️⃣ RESET COMPLET
- Supprime TOUT et recommence à zéro
- Nouvelle BD + 35 produits + images
- **Durée:** ~1 minute

---

## 🔐 Identifiants par défaut

### Compte Admin
```
Email: admin@novashop.local
Mot de passe: admin123
```

### Comptes de test (6 utilisateurs)
```
user1@test.local / password1
user2@test.local / password2
user3@test.local / password3
user4@test.local / password4
user5@test.local / password5
user6@test.local / password6
```

---

## 📋 Dépendances Requises

### PHP 8.2
- **Téléchargement:** https://windows.php.net/download/
- **Version:** x64 Non Thread Safe (NTS)
- **Installation:** C:\php-8.2
- **Inclus:** PDO, JSON, cURL, Fileinfo

### MariaDB 10.6+
- **Téléchargement:** https://mariadb.org/download/
- **Type:** Community Edition
- **Installation:** Typique (C:\Program Files\MariaDB...)
- **Port:** 3306 (défaut)
- **Root:** root / root

---

## 🔧 Configuration Système

### PATH Windows
Le script `setup_auto.bat` ajoute automatiquement:
- `C:\php-8.2` pour PHP
- `C:\Program Files\MariaDB<version>\bin` pour MariaDB

### Service MariaDB
Le service démarre automatiquement au démarrage du PC.
Pour le gérer manuellement:
```
Services Windows (services.msc) → MariaDB → Démarrer/Arrêter
```

### Port 8000
Le serveur PHP s'exécute sur `http://localhost:8000`
Si le port est occupé, modifiez dans `restart.bat`.

---

## 🆘 Dépannage

### PHP not recognized
```
1. Exécutez setup_auto.bat
2. Redémarrez l'invite de commandes
3. Essayez php --version
```

### MySQL connection error
```
1. Ouvrez services.msc (Windows)
2. Cherchez "MariaDB"
3. Clic droit → Démarrer
4. Réessayez
```

### Port 8000 already in use
```
1. Ouvrez restart.bat avec un éditeur
2. Cherchez: php -S localhost:8000
3. Remplacez 8000 par un autre port (ex: 8001)
4. Sauvegardez et relancez
```

### Images ne s'affichent pas
```
1. Exécutez restart.bat → Option 4 (Télécharger images)
2. Nettoyez le cache navigateur (Option 5)
3. Appuyez sur Ctrl+Shift+R
```

### Base de données vide
```
1. Exécutez restart.bat
2. Choisissez Option 3 (Réinitialiser BD) ou Option 1 (Setup complet)
3. Attendez la fin du processus
```

---

## 📂 Structure des Fichiers

```
NovaShop Pro/
├── setup_auto.bat                 ← DÉMARREZ ICI!
├── restart.bat                    ← Menu principal
├── QUICKSTART.md                  ← Guide rapide
├── SETUP_GUIDE.md                 ← Guide détaillé
├── INSTALLATION.md
├── README_FINAL.md
├── start_novashop.php             ← Initialisation BD
│
├── Public/
│   ├── index.php                  ← Point d'entrée web
│   ├── router.php                 ← Routeur
│   └── Assets/
│       └── Images/
│           └── products/          ← Images ici
│
├── App/
│   ├── Controllers/               ← Logique des pages
│   ├── Models/                    ← Modèles de données
│   └── Views/                     ← Templates HTML
│
└── scripts/
    ├── create_admin.php
    ├── setup.sql
    ├── seed.sql
    └── seed_premium.sql
```

---

## ✅ Checklist d'Installation Complète

- [ ] Télécharger le projet NovaShop Pro
- [ ] Exécuter `setup_auto.bat` (clic droit → Administrateur)
- [ ] Télécharger et installer PHP si demandé
- [ ] Télécharger et installer MariaDB si demandé
- [ ] Exécuter `restart.bat`
- [ ] Choisir Option 1 (SETUP COMPLET)
- [ ] Attendre que la BD soit créée
- [ ] Vérifier que le serveur démarre sur http://localhost:8000
- [ ] Se connecter avec admin@novashop.local / admin123
- [ ] Naviguer et tester les fonctionnalités

---

## 💡 Conseils

1. **Première fois:** Utilisez toujours l'Option 1 (SETUP COMPLET)
2. **Après modifications:** Option 2 (Relancer serveur)
3. **Problèmes:** Option 6 (Reset complet) pour repartir de zéro
4. **Slow internet:** Les images prennent du temps, soyez patient

---

## 📞 Support

Si vous rencontrez des problèmes:

1. Consultez `SETUP_GUIDE.md` (section Dépannage)
2. Vérifiez que PHP et MariaDB sont installés
3. Relancez `setup_auto.bat` pour réinstaller les dépendances
4. Utilisez l'Option 6 (Reset complet) pour repartir de zéro

---

## 🔗 Ressources

- **PHP Official:** https://www.php.net/
- **MariaDB Official:** https://mariadb.org/
- **Windows Services:** `services.msc`
- **Command Prompt:** Recherchez "cmd" ou "powershell"

---

**Prêt à démarrer? Double-cliquez sur `setup_auto.bat`!** 🚀
