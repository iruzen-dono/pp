# 🛍️ NovaShop Pro - Documentation Complète

## 📋 Table des matières
1. [Structure du projet](#structure)
2. [Architecture MVC](#architecture)
3. [Pré-requis et Installation](#installation)
4. [Configuration de la base de données](#bdd)
5. [Routes disponibles](#routes)
6. [Fonctionnalités implémentées](#fonctionnalites)
7. [Guide d'exécution](#execution)

---

## 📁 Structure du projet {#structure}

```
NovaShop Pro/
├── App/
│   ├── Core/                  # Cœur du framework MVC
│   │   ├── App.php           # Point d'entrée principal
│   │   ├── Router.php        # Routeur d'URL
│   │   ├── Controller.php    # Classe mère des contrôleurs
│   │   ├── Model.php         # Classe mère des modèles
│   │   └── Database.php      # Redirect vers Config/Database
│   ├── Config/
│   │   └── Database.php      # Connexion PDO (Singleton)
│   ├── Controllers/          # Contrôleurs métier
│   │   ├── HomeController.php
│   │   ├── AuthController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── OrderController.php
│   │   └── AdminController.php
│   ├── Models/               # Modèles de données
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   └── Category.php
│   ├── Views/                # Templates HTML
│   │   ├── Layouts/
│   │   │   ├── header.php
│   │   │   └── footer.php
│   │   ├── Home/
│   │   ├── Auth/
│   │   ├── Products/
│   │   ├── Cart/
│   │   ├── Orders/
│   │   └── Admin/
│   └── middleware/           # Contrôle d'accès
│       ├── AuthMiddleware.php
│       └── AdminMiddleware.php
└── Public/
    ├── index.php             # Point d'entrée HTTP
    └── Assets/
        ├── Css/
        │   ├── Style.css
        │   └── Admin.css
        └── Js/
```

---

## 🏗️ Architecture MVC {#architecture}

### **Modèle MVC (Model-View-Controller)**

```
USER REQUEST
    ↓
[Router.php] ← Parse l'URL (?url=products/show)
    ↓
[Controllers/ProductController.php] ← Récupère les données
    ↓
[Models/Product.php] ← Query la BDD
    ↓
[Database.php] ← Connexion PDO
    ↓
[MySQL] ← Exécute la requête
    ↓
[View/Products/show.php] ← Affiche le résultat avec header/footer
```

### **Flow d'une requête**

1. `index.php` démarre la session et crée une instance `App`
2. `App::run()` appelle `Router::dispatch()`
3. Router parse l'URL depuis `$_GET['url']`
4. Crée une instance du contrôleur approprié
5. Appelle la méthode avec les paramètres
6. Contrôleur récupère les données via modèles
7. Contrôleur appelle `$this->view()` pour afficher le résultat

---

## ⚙️ Pré-requis et Installation {#installation}

### **Pré-requis système**

- **PHP 8.0+** (testé sur PHP 8.1, compatible PHP 10.0)
- **MySQL 5.7+** ou **MariaDB 10.3+**
- **Serveur web** : Apache (avec mod_rewrite) ou Nginx
- **Git** (optionnel)

### **Installation pas à pas**

```bash
# 1. Cloner le projet
git clone <repo-url> novashop
cd novashop

# 2. Configurer les droits d'accès
chmod -R 755 Public/
chmod -R 755 App/Views/

# 3. Créer le dossier de uploads (optionnel)
mkdir -p Public/Assets/Uploads
chmod 777 Public/Assets/Uploads

# 4. Configurer le serveur (voir section Configuration)
```

### **Configuration serveur Apache (.htaccess)**

Créer [Public/.htaccess](Public/.htaccess) :
```apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /NovaShop Pro/Public/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php?url=$1 [QSA,L]
</IfModule>
```

### **Configuration serveur Nginx**

Ajouter dans la config du site :
```nginx
location ~ \.php$ {
    fastcgi_pass unix:/var/run/php-fpm.sock;
    fastcgi_index index.php;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    include fastcgi_params;
}

location / {
    try_files $uri $uri/ /index.php?url=$uri&$args;
}
```

---

## 🗄️ Configuration de la base de données {#bdd}

### **Paramètres de connexion**

Fichier: `App/Config/Database.php`

```php
"mysql:host=localhost;dbname=novashop;charset=utf8mb4",
"root",        // User
""             // Password (vide par défaut)
```

### **Créer la base de données MySQL**

```sql
-- Créer la base
CREATE DATABASE novashop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE novashop;

-- Table Utilisateurs
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table Catégories
CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table Produits
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

-- Table Commandes
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) DEFAULT 0,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Table Articles de commande
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Ajouter des données de test
INSERT INTO categories (name, description) VALUES
('Électronique', 'Appareils électroniques'),
('Vêtements', 'Articles de mode');

INSERT INTO products (name, description, price, category_id, stock) VALUES
('Laptop Pro', 'Ordinateur portable 15 pouces', 1299.99, 1, 10),
('T-Shirt NovaShop', 'T-shirt collection spéciale', 19.99, 2, 50);
```

---

## 🛣️ Routes disponibles {#routes}

### **Format URL**
```
http://localhost/NovaShop Pro/Public/?url=controller/method[/param1/param2]
```

### **Routes implémentées**

| URL | Méthode | Description |
|-----|---------|-------------|
| `/` ou `/?url=home/index` | GET | Page d'accueil |
| `/?url=auth/register` | GET/POST | Inscription utilisateur |
| `/?url=auth/login` | GET/POST | Connexion utilisateur |
| `/?url=auth/logout` | GET | Déconnexion |
| `/?url=products` | GET | Liste des produits |
| `/?url=products/show?id=1` | GET | Détails d'un produit |
| `/?url=cart` | GET | Afficher le panier |
| `/?url=cart/add` | POST | Ajouter au panier |
| `/?url=cart/remove?id=1` | GET | Retirer du panier |
| `/?url=orders` | GET | Mes commandes (auth required) |
| `/?url=orders/show?id=1` | GET | Détails commande (auth required) |
| `/?url=orders/create` | POST | Créer commande (auth required) |
| `/?url=admin/dashboard` | GET | Dashboard admin (admin only) |
| `/?url=admin/users` | GET | Gérer utilisateurs (admin only) |
| `/?url=admin/products` | GET | Gérer produits (admin only) |
| `/?url=admin/orders` | GET | Gérer commandes (admin only) |

---

## ✨ Fonctionnalités implémentées {#fonctionnalites}

### **1. Authentification et Utilisateurs**
- ✅ Inscription avec email/mot de passe
- ✅ Hachage bcrypt sécurisé (PASSWORD_BCRYPT)
- ✅ Connexion avec vérification
- ✅ Sessions PHP sécurisées
- ✅ Déconnexion complète
- ✅ Rôles (user/admin)

### **2. Gestion des Produits**
- ✅ Liste des produits avec catégories
- ✅ Détails produit avec prix et description
- ✅ Recherche par catégorie
- ✅ CRUD complet (Create, Read, Update, Delete)
- ✅ Gestion du stock

### **3. Panier d'achat**
- ✅ Stockage en session
- ✅ Ajouter/Retirer produits
- ✅ Quantités variables
- ✅ Persistance pendant la session

### **4. Gestion des commandes**
- ✅ Création de commande
- ✅ Historique des commandes
- ✅ Suivi du statut (pending, confirmed, shipped, delivered, cancelled)
- ✅ Articles de commande liés
- ✅ Calculation du total

### **5. Contrôle d'accès (Middleware)**
- ✅ AuthMiddleware : Vérifie la connexion
- ✅ AdminMiddleware : Restreint l'accès aux admins

### **6. Architecture MVC robuste**
- ✅ Classe Model commune avec PDO
- ✅ Héritage des contrôleurs
- ✅ Système de vues avec layouts
- ✅ Routeur flexible
- ✅ Gestion d'erreurs

### **7. Sécurité**
- ✅ Hachage des mots de passe (bcrypt)
- ✅ Connexions PDO sécurisées (prepared statements)
- ✅ Sanitization des URLs
- ✅ Protection XSS (htmlspecialchars)
- ✅ Sessions sécurisées

---

## 🚀 Guide d'exécution {#execution}

### **Étape 1 : Préparation**

1. Installer PHP et MySQL
2. Télécharger/cloner le projet
3. Créer la base de données (voir section BDD)
4. Configurer le serveur (Apache/Nginx)

### **Étape 2 : Démarrage avec Apache**

```bash
# Si vous avez Apache avec PHP built-in
cd /path/to/NovaShop\ Pro/Public
php -S localhost:8000
```

Puis accéder à : `http://localhost:8000/?url=home/index`

### **Étape 3 : Test des fonctionnalités**

**A. Tester l'accueil**
- Accès : `http://localhost:8000/`
- Doit afficher la page d'accueil avec le logo NovaShop

**B. S'inscrire**
- Accès : `http://localhost:8000/?url=auth/register`
- Remplir le formulaire (nom, email, mot de passe)
- La session créera l'utilisateur en BDD

**C. Se connecter**
- Accès : `http://localhost:8000/?url=auth/login`
- Entrer l'email et mot de passe
- Sera redirigé vers la page d'accueil

**D. Voir les produits**
- Accès : `http://localhost:8000/?url=products`
- Affiche la liste des produits (les insérés en SQL)

**E. Ajouter au panier**
- Cliquer sur "Voir détails" d'un produit
- Entrer une quantité et "Ajouter au panier"
- Le produit s'ajoutera à `$_SESSION['cart']`

**F. Voir le panier**
- Accès : `http://localhost:8000/?url=cart`
- Affiche les produits ajoutés avec quantités

**G. Créer une commande**
- Depuis le panier, cliquer "Valider la commande"
- La commande se crée en BDD avec statut 'pending'

**H. Voir les commandes**
- Accès : `http://localhost:8000/?url=orders`
- Affiche l'historique des commandes de l'utilisateur

**I. Accès Admin (optionnel)**
- Modifier l'utilisateur en SQL : `UPDATE users SET role='admin' WHERE id=1;`
- Accès : `http://localhost:8000/?url=admin/dashboard`
- Affiche le dashboard d'administration

### **Étape 4 : Troubleshooting**

| Problème | Cause | Solution |
|----------|-------|----------|
| **Erreur 404 "Controller not found"** | URL mal formée ou contrôleur absent | Vérifier la syntaxe `?url=controller/method` |
| **Erreur BDD "connection refused"** | MySQL n'est pas lancé | Démarrer MySQL : `mysql.server start` |
| **CSS ne s'applique pas** | Mauvais chemin dans header.php | Vérifier que `/assets/css/style.css` existe |
| **Session non persistante** | session_start() manquant | Assuré que `index.php` commence par `session_start()` |
| **Middleware error 403** | Utilisateur non admin | Vérifier le rôle dans la BDD |
| **Prepared statement error** | Paramètres mal formés | Vérifier la syntaxe dans les modèles |

---

## 🔐 Sécurité supplémentaire recommandée

1. **HTTPS** : Utiliser SSL/TLS en production
2. **CSRF Token** : Ajouter pour les formulaires POST
3. **Rate Limiting** : Limiter les tentatives de connexion
4. **Validation** : Valider tous les formulaires côté serveur
5. **Logs** : Ajouter du logging pour les actions sensibles
6. **Permissions fines** : Vérifier l'ownership des ressources

---

## 📞 Résumé des fichiers clés

| Fichier | Rôle |
|---------|------|
| `Public/index.php` | Point d'entrée, initialise session et app |
| `App/Core/Router.php` | Parse les URLs, dispatcher les requêtes |
| `App/Core/Model.php` | Classe de base avec PDO et requêtes |
| `App/Config/Database.php` | Singleton pour la connexion MySQL |
| `App/Controllers/*` | Logique métier de chaque page |
| `App/Models/*` | Gestion des données (CRUD) |
| `App/Views/*` | Templates HTML |
| `App/middleware/*` | Contrôle d'accès |

---

**Projet développé avec ❤️ en PHP natif MVC**
