# RAPPORT DE PROJET - NovaShop Pro

## Table des matières
1. [Résumé exécutif](#résumé-exécutif)
2. [Vue d'ensemble du projet](#vue-densemble-du-projet)
3. [Architecture générale](#architecture-générale)
4. [Stack technologique](#stack-technologique)
5. [Structure des fichiers](#structure-des-fichiers)
6. [Modèle de données](#modèle-de-données)
7. [Fonctionnalités principales](#fonctionnalités-principales)
8. [Architecture logique](#architecture-logique)
9. [Authentification et sécurité](#authentification-et-sécurité)
10. [Guide d'installation](#guide-dinstallation)
11. [Documentation d'utilisation](#documentation-dutilisation)
12. [Maintenance et outils](#maintenance-et-outils)

---

## Résumé exécutif

**NovaShop Pro** est une plateforme de commerce électronique moderne et complète, développée en PHP natif selon le pattern architectural MVC (Model-View-Controller). Ce projet démontre une implémentation professionnelle d'une boutique en ligne avec :

- ✅ **Système d'authentification sécurisé** (enregistrement, connection, réinitialisation de mot de passe)
- ✅ **Catalogue de produits** avec recherche, filtrage et variantes
- ✅ **Panier d'achat persistant** avec gestion des variantes
- ✅ **Système de commandes** complet (création, suivi, statuts)
- ✅ **Panel d'administration** (gestion utilisateurs, produits, commandes)
- ✅ **Système de rôles** (user, moderator, admin, super_admin)
- ✅ **Base de données relational** avec intégrité référentielle
- ✅ **Interface responsive** et professionnelle

---

## Vue d'ensemble du projet

### Objectifs

NovaShop Pro a été conçu pour démontrer :
1. Une architecture web moderne et scalable
2. Les meilleures pratiques en PHP natif (sans framework)
3. La sécurité des applications web (authentification, CSRF, injection SQL)
4. La gestion de la complexité métier (panier, commandes, stocks)
5. L'ergonomie utilisateur et l'interface professionnelle

### Public cible

- **Clients finaux** : accès libre au catalogue, création de compte, gestion des commandes
- **Administrateurs** : gestion complète du catalogue, des utilisateurs et des commandes
- **Super administrateurs** : accès aux fonctionnalités de haut niveau

---

## Architecture générale

### Pattern MVC (Model-View-Controller)

NovaShop Pro suit le pattern MVC classique :

```
Requête HTTP
     ↓
Router (dispatcher)
     ↓
Controller (logique métier)
     ↓
Model (accès aux données)
     ↓
Database
```

**Cycle de vie d'une requête :**

1. **Request** : Utilisateur accède à une URL
2. **Router** : `App\Core\Router` analyse l'URL et achemine vers le bon contrôleur
3. **Controller** : Gère la logique métier (validation, appels modèles)
4. **Model** : Exécute les requêtes SQL pour récupérer/modifier des données
5. **View** : Affiche le résultat à l'utilisateur
6. **Response** : HTML retourné au navigateur

### Point d'entrée

```
Public/index.php
     ↓ (configure l'autoloader)
     ↓ (démarre la session)
Public/router.php (fallback pour le serveur PHP intégré)
     ↓
App/Core/App.php (bootstrap)
     ↓
App/Core/Router.php (routage des URLs)
```

---

## Stack technologique

### Backend
- **PHP** 7.4+ (natif, sans framework externe)
- **MySQL 5.7+** (base de données relational)
- **PDO** (object database driver pour PHP)
- **Session HTTP** (gestion d'authentification)

### Frontend
- **HTML5** et **CSS3**
- **Bootstrap 5** (framework CSS responsive)
- **Font Awesome** (icônes)
- **JavaScript vanilla** (interactions frontend)

### Dépendances (Composer)
```json
{
  "php": ">=7.4",
  "phpunit/phpunit": "^9.5 || ^10.0",
  "phpstan/phpstan": "^1.9",
  "squizlabs/php_codesniffer": "^3.7"
}
```

### Serveur de développement
- **PHP built-in server** : `php -S localhost:8000 -t Public`
- **Apache/Nginx** compatible (avec configuration `.htaccess`)

---

## Structure des fichiers

```
NovaShop Pro/
├── Public/                          # Point d'entrée web public
│   ├── index.php                    # Démarreur principal (autoloader)
│   ├── router.php                   # Routeur pour php -S
│   ├── .htaccess                    # Configuration Apache
│   └── Assets/
│       ├── css/
│       │   ├── bootstrap.min.css    # Bootstrap framework
│       │   └── style.css            # Styles personnalisés
│       ├── js/
│       │   └── bootstrap.bundle.min.js
│       └── Images/
│           └── products/             # Images des produits
│
├── App/                             # Code applicatif
│   ├── Core/
│   │   ├── App.php                  # Bootstrap application
│   │   ├── Router.php               # Dispatcher des routes
│   │   ├── Controller.php           # Classe parent pour contrôleurs
│   │   └── Model.php                # Classe parent pour modèles
│   │
│   ├── Config/
│   │   ├── Database.php             # Connexion PDO (singleton)
│   │   ├── env.php                  # Variables d'environnement
│   │   └── config.php               # Constantes globales
│   │
│   ├── Controllers/                 # Logique métier
│   │   ├── AuthController.php       # Authentification
│   │   ├── ProductController.php    # Catalogue produits
│   │   ├── CartController.php       # Gestion panier
│   │   ├── OrderController.php      # Gestion commandes
│   │   ├── AdminController.php      # Panel admin
│   │   ├── HomeController.php       # Page d'accueil
│   │   └── UserController.php       # Profil utilisateur
│   │
│   ├── Models/                      # Accès aux données (ORM-like)
│   │   ├── User.php                 # Modèle Utilisateur
│   │   ├── Product.php              # Modèle Produit
│   │   ├── Order.php                # Modèle Commande
│   │   ├── OrderItem.php            # Modèle Article de commande
│   │   ├── Category.php             # Modèle Catégorie
│   │   ├── PasswordReset.php        # Tokens de réinitialisation
│   │   ├── EmailVerificationToken.php
│   │   └── Promotion.php            # Modèle Promotion
│   │
│   ├── Views/                       # Templates HTML
│   │   ├── layouts/
│   │   │   ├── base.html            # Layout principal
│   │   │   ├── auth-base.html       # Layout authentification
│   │   │   └── admin-base.html      # Layout admin
│   │   ├── auth/
│   │   │   ├── login.php
│   │   │   ├── register.php
│   │   │   ├── forgot.php
│   │   │   └── reset-password.php
│   │   ├── products/
│   │   │   ├── index.php            # Catalogue
│   │   │   └── show.php             # Détail produit
│   │   ├── cart/
│   │   │   └── index.php
│   │   ├── orders/
│   │   │   ├── index.php
│   │   │   └── show.php
│   │   ├── admin/
│   │   │   ├── dashboard.php
│   │   │   ├── users.php
│   │   │   ├── products.php
│   │   │   ├── edit_product.php
│   │   │   ├── orders.php
│   │   │   └── manage-roles.php
│   │   └── home/
│   │       └── index.php
│   │
│   ├── Middleware/                  # Middlewares de sécurité
│   │   ├── AuthMiddleware.php       # Vérification authentification
│   │   ├── AdminMiddleware.php      # Vérification admin
│   │   └── CsrfMiddleware.php       # Protection CSRF
│   │
│   └── Services/                    # Services métier
│       └── (services partagés)
│
├── scripts/                         # Scripts de maintenance
│   ├── check_product_images.php     # Vérification images
│   ├── repair_missing_images.php    # Réparation images
│   ├── add_is_active_column.php     # Migration colonne
│   ├── add_variants_column.php      # Migration variantes
│   ├── add_email_verified_at_column.php
│   ├── test_registration.php        # Tests
│   └── test_product_edit.php
│
├── setup.sql                        # Schéma base de données
├── migrate_email_verification.sql   # Migration email
├── composer.json                    # Dépendances PHP
├── .gitignore                       # Fichiers ignorés Git
└── README.md                        # Documentation rapide
```

---

## Modèle de données

### Diagramme entités-relations

```
┌─────────────────────────┐
│       USERS             │
├─────────────────────────┤
│ id (PK)                 │
│ name                    │
│ email (UNIQUE)          │
│ password                │
│ role (ENUM)             │
│ is_active               │
│ email_verified_at       │
│ deactivated_at          │
│ created_at              │
│ updated_at              │
└──────────┬──────────────┘
           │ 1
           │
        has many
           │
           │ *
     ┌─────┴─────────────────────────────┐
     │                                   │
┌────┴──────────────┐         ┌──────────┴─────────┐
│    ORDERS         │         │ PASSWORD_RESETS    │
├─────────────────┤         ├────────────────────┤
│ id (PK)         │         │ id (PK)            │
│ user_id (FK) ───┼─────────┤ user_id (FK)   │
│ total           │         │ token              │
│ status (ENUM)   │         │ expires_at         │
│ created_at      │         │ created_at         │
│ updated_at      │         └────────────────────┘
└────┬────────────┘
     │ 1
     │
  has many
     │ *
┌────┴──────────────────┐
│   ORDER_ITEMS         │
├─────────────────────┤
│ id (PK)             │
│ order_id (FK) ──────┤─ to ORDER
│ product_id (FK) ─┐  │
│ quantity        │  │
│ price           │  │
└────────────────┘  │
                    │ *
                    │
              ┌─────┴────────────────────┐
              │    PRODUCTS              │
              ├─────────────────────────┤
              │ id (PK)                 │
              │ name                    │
              │ description             │
              │ image_url               │
              │ price                   │
              │ category_id (FK)  ─┐    │
              │ stock                  │
              │ variants (TEXT)        │
              │ created_at             │
              │ updated_at             │
              └─────────────────────────┘
                    *
                    │
                 belongs
                    │ 1
              ┌─────┴────────────────────┐
              │   CATEGORIES             │
              ├─────────────────────────┤
              │ id (PK)                 │
              │ name (UNIQUE)           │
              │ description             │
              │ created_at              │
              │ updated_at              │
              └─────────────────────────┘
```

### Tables principales

#### TABLE: `users`
Stocke les informations des utilisateurs et leurs rôles.

| Colonne | Type | Constraint | Description |
|---------|------|-----------|-------------|
| id | INT | PRIMARY KEY | Identifiant unique |
| name | VARCHAR(100) | NOT NULL | Nom complet |
| email | VARCHAR(100) | UNIQUE, NOT NULL | Email unique |
| password | VARCHAR(255) | NOT NULL | Hash bcrypt du mot de passe |
| role | ENUM | DEFAULT 'user' | Rôle : user, moderator, admin, super_admin |
| is_active | BOOLEAN | DEFAULT TRUE | Compte actif ou désactivé |
| email_verified_at | TIMESTAMP | NULL | Date de vérification email |
| deactivated_at | TIMESTAMP | NULL | Date de désactivation |
| created_at | TIMESTAMP | DEFAULT NOW | Date création |
| updated_at | TIMESTAMP | ON UPDATE | Date modification |

**Indices** : email, role, is_active

#### TABLE: `products`
Catalogue de produits avec métadonnées.

| Colonne | Type | Constraint | Description |
|---------|------|-----------|-------------|
| id | INT | PRIMARY KEY | Identifiant unique |
| name | VARCHAR(150) | NOT NULL | Nom du produit |
| description | TEXT | NULL | Description longue |
| image_url | VARCHAR(500) | NULL | URL/chemin de l'image |
| price | DECIMAL(10,2) | NOT NULL | Prix unitaire |
| category_id | INT | FOREIGN KEY | Référence catégorie |
| stock | INT | DEFAULT 0 | Quantité en stock |
| variants | TEXT | DEFAULT '' | Variantes comma-séparées |
| created_at | TIMESTAMP | DEFAULT NOW | Date création |
| updated_at | TIMESTAMP | ON UPDATE | Date modification |

**Indices** : category_id, FULLTEXT (name, description)

#### TABLE: `orders`
Enregistre les commandes des utilisateurs.

| Colonne | Type | Constraint | Description |
|---------|------|-----------|-------------|
| id | INT | PRIMARY KEY | Identifiant unique |
| user_id | INT | FOREIGN KEY NOT NULL | Référence utilisateur |
| total | DECIMAL(10,2) | DEFAULT 0 | Total commande |
| status | ENUM | DEFAULT 'pending' | Statut : pending, confirmed, shipped, delivered, cancelled |
| created_at | TIMESTAMP | DEFAULT NOW | Date création |
| updated_at | TIMESTAMP | ON UPDATE | Date modification |

**Indices** : user_id, status

#### TABLE: `order_items`
Articles individuels dans chaque commande.

| Colonne | Type | Constraint | Description |
|---------|------|-----------|-------------|
| id | INT | PRIMARY KEY | Identifiant unique |
| order_id | INT | FOREIGN KEY NOT NULL | Référence commande |
| product_id | INT | FOREIGN KEY NOT NULL | Référence produit |
| quantity | INT | > 0 | Quantité |
| price | DECIMAL(10,2) | NOT NULL | Prix au moment de la commande |

**Indices** : order_id, product_id

---

## Fonctionnalités principales

### 1. Authentification utilisateur

**Fichiers** : `AuthController.php`, `User.php`

#### Enregistrement (`/register`)
- Validation des données (email unique, mot de passe ≥ 6 caractères)
- Hash bcrypt du mot de passe (PASSWORD_BCRYPT)
- Création utilisateur avec rôle par défaut "user"
- Statut `is_active=TRUE`, `email_verified_at=NOW()`
- Message de confirmation

#### Connexion (`/login`)
- Vérification email/mot de passe
- Protection contre les attaques par force brute (message générique)
- Vérification du statut `is_active`
- Régénération de session (sécurité)
- Stockage des données session : id, name, email, role

#### Réinitialisation de mot de passe (`/forgot`, `/reset-password`)
- Génération de token aléatoire
- Envoi par email (mock en développement)
- Vérification de l'expiration du token
- Mise à jour du mot de passe

#### Middleware authentification
```php
// Vérifie que l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header("Location: /login");
    exit;
}
```

### 2. Catalogue produits

**Fichiers** : `ProductController.php`, `Product.php`

#### Fonctionnalités
- **Listing produits** (`/products`) : affiche tous les produits avec pagination
- **Recherche** (`?q=terme`) : recherche fulltext (nom + description)
- **Détail produit** (`/product/{id}`) : affiche infos complètes + variantes
- **Variantes** : affichage des options disponibles (tailles, couleurs, etc.)
- **Stock** : affichage du stock disponible

#### Recherche FULLTEXT
```sql
SELECT * FROM products 
WHERE MATCH(name, description) AGAINST(? IN BOOLEAN MODE)
```

### 3. Panier d'achat

**Fichier** : `CartController.php`

#### Stockage
Panier persistant en session :
```php
$_SESSION['cart'] = [
    'product_id' => [
        'variants' => [
            'variant_name' => [
                'quantity' => 2,
                'price' => 99.99
            ]
        ]
    ]
];
```

#### Opérations
- **Ajouter au panier** : `POST /cart/add` avec variant
- **Augmenter quantité** : `POST /cart/update`
- **Supprimer produit** : `POST /cart/remove`
- **Vider panier** : `POST /cart/clear`

#### Affichage
- Nombre d'articles
- Total avec calcul dynamique
- Détail par produit et variante

### 4. Système de commandes

**Fichiers** : `OrderController.php`, `Order.php`, `OrderItem.php`

#### Cycle de vie
1. **Création** (`/orders/create`) : conversion du panier en commande
2. **Confirmation** : commande passe au statut "confirmed"
3. **Expédition** : admin marque comme "shipped"
4. **Livraison** : client ou admin marque "delivered"
5. **Annulation** : possible avant expédition

#### Statuts
```
pending → confirmed → shipped → delivered
              ↓
           cancelled
```

#### Données conservées
- Prix au moment de la commande (no update)
- Quantité commandée
- Référence produit
- Total commande

### 5. Panel d'administration

**Fichier** : `AdminController.php`

#### Accès
- Réservé aux rôles : `admin` et `super_admin`
- Middleware : vérification `AdminMiddleware.php`
- URL : `/admin/...`

#### Fonctionnalités

**Dashboard** (`/admin`)
- Nombre d'utilisateurs
- Nombre de produits
- Nombre de commandes

**Gestion utilisateurs** (`/admin/users`)
- Listing avec tri (nom, email, rôle, date création)
- Modification rôle
- Activation/Désactivation de compte
- Suppression (soft delete → deactivated)

**Gestion produits** (`/admin/products`)
- Listing avec recherche
- Création (upload image)
- Édition (nom, prix, stock, variantes, description)
- Suppression
- Upload d'images avec validation MIME

**Gestion commandes** (`/admin/orders`)
- Listing avec filtrage par statut
- Détail commande (articles, total)
- Modification statut
- Suivi client

**Gestion rôles** (`/admin/manage-roles`)
- Modification rôle utilisateur
- Restriction : super_admin ne peut pas être changé

### 6. Système de variantes

**Concept** : Options de produit (tailles, couleurs, capacités)

#### Structure
```php
// Stockage en base : TEXT comma-séparé
variants = "S, M, L, XL"
          | "Noir, Blanc, Gris"
          | "256GB, 512GB, 1TB"

// Affichage
$variants = explode(',', $product['variants']);
// → ['S', 'M', 'L', 'XL']
```

#### Utilisation panier
Chaque variante est trackée indépendamment :
```php
$_SESSION['cart'][product_id]['variants']['S'] = ['quantity' => 2, 'price' => 99.99]
$_SESSION['cart'][product_id]['variants']['M'] = ['quantity' => 1, 'price' => 99.99]
```

---

## Architecture logique

### Pattern MVC en détail

#### Controllers (Logique métier)
```php
<?php
namespace App\Controllers;

class ProductController extends Controller {
    // 1. Récupère request
    // 2. Valide input
    // 3. Appelle Model
    // 4. Passe données à View
    
    public function index() {
        $products = (new Product())->getAll();
        $this->view('products/index', compact('products'));
    }
}
```

#### Models (Accès données)
```php
<?php
namespace App\Models;

class Product extends Model {
    // Requêtes SQL
    // Pas de logique métier ici
    
    public function getAll() {
        return $this->run("SELECT * FROM products");
    }
    
    public function search($keyword) {
        return $this->run(
            "SELECT * FROM products WHERE name LIKE ?",
            ['%' . $keyword . '%']
        );
    }
}
```

#### Views (Présentation)
```html
<!-- App/Views/products/index.php -->
<div class="products">
    <?php foreach ($products as $p): ?>
        <div class="product-card">
            <h3><?= htmlspecialchars($p['name']) ?></h3>
            <p><?= htmlspecialchars($p['description']) ?></p>
            <a href="/product/<?= $p['id'] ?>">Voir détails</a>
        </div>
    <?php endforeach; ?>
</div>
```

### Flux données complet : Exemple "Ajouter au panier"

```
1. Utilisateur clique "Ajouter au panier"
           ↓
2. POST /cart/add?product_id=5&variant=S
           ↓
3. Router → CartController->add($productId, $variant)
           ↓
4. Controller valide : produit existe ? stock OK ?
           ↓
5. Model → Product->getById(5) [récupère prix]
           ↓
6. Controller → $_SESSION['cart'][5]['variants']['S'] = [qty, price]
           ↓
7. Redirect to /cart
           ↓
8. CartController->index()
           ↓
9. View → calcule total, affiche tous items
           ↓
10. HTML retourné au navigateur
```

---

## Authentification et sécurité

### 1. Protection contre l'injection SQL

**Méthode** : Requêtes paramétrées (prepared statements)

```php
// ❌ MAUVAIS (injection possible)
$result = $db->query("SELECT * FROM users WHERE email = '$email'");

// ✅ BON (safe)
$stmt = $db->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
$stmt->execute([$email]);
```

**Implémentation** : Class `Model.php` base pour tous les modèles
```php
protected function run(string $sql, array $params = [], bool $single = false) {
    $stmt = $this->db->prepare($sql);
    $stmt->execute($params);  // PDO gère l'échappement
    // ...
}
```

### 2. Hachage de mot de passe

**Algorithme** : PASSWORD_BCRYPT (salt aléatoire)

```php
// Enregistrement
$hashedPassword = password_hash($_POST['password'], PASSWORD_BCRYPT);
// insert into users (password) values (...)

// Connexion
if (password_verify($_POST['password'], $user['password'])) {
    // mot de passe correct
}
```

**Caractéristiques** :
- Salt aléatoire (16 bytes)
- Adaptation automatique (facteur de coût)
- Résistant aux attaques brute force (long à calculer)

### 3. Protection CSRF (Cross-Site Request Forgery)

**Fichier** : `CsrfMiddleware.php`

```php
// Génération token (dans formulaire)
<input type="hidden" name="csrf_token" value="<?= session_id() ?>">

// Vérification (dans controller)
if ($_SESSION['csrf_token'] !== $_POST['csrf_token']) {
    die("Error: Invalid CSRF token");
}
```

### 4. Sécurité session

```php
// À la connexion
session_regenerate_id(true);  // Nouveau session ID
$_SESSION['user'] = $userData;  // Stockage utilisateur

// Vérification (middleware)
if (!isset($_SESSION['user'])) {
    header("Location: /login");
}
```

### 5. Échappement XSS (Cross-Site Scripting)

```html
<!-- ❌ MAUVAIS (injection XSS) -->
<h1><?= $product['name'] ?></h1>

<!-- ✅ BON (safe) -->
<h1><?= htmlspecialchars($product['name']) ?></h1>
<p><?= htmlspecialchars($product['description']) ?></p>
```

### 6. Validation input

```php
// Vérification email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error = "Email invalide";
}

// Sanitization URL
$keyword = filter_var($_GET['q'], FILTER_SANITIZE_STRING);

// Vérification type numérique
$productId = (int)$_GET['id'];
```

### 7. Contrôle d'accès (Middleware)

**AdminMiddleware.php**
```php
public static function check() {
    if (!isset($_SESSION['user'])) {
        header("Location: /login");
        exit;
    }
    
    if (!in_array($_SESSION['user']['role'], ['admin', 'super_admin'])) {
        http_response_code(403);
        die("Accès refusé");
    }
}
```

---

## Guide d'installation

### Prérequis

- **PHP** 7.4 ou supérieur (avec mysqli, pdo_mysql)
- **MySQL** 5.7+
- **Composer** (optionnel)
- **Git** (optionnel)

### Installation pas à pas

#### 1. Préparation serveur

```bash
# Vériser PHP
php --version
# Output: PHP 7.4.x ou supérieur

# Vérifier MySQL
mysql --version
# Output: mysql Ver ...
```

#### 2. Clonage/copie du projet

```bash
# Via Git
git clone <repository> novashop-pro
cd novashop-pro

# Ou copie manuelle des fichiers
```

#### 3. Configuration base de données

**Fichier** : `App/Config/env.php`

```php
// Créer si n'existe pas
return [
    'db_host' => 'localhost',
    'db_name' => 'novashop_db',
    'db_user' => 'root',
    'db_pass' => '0000'  // Adapter
];
```

#### 4. Création base de données

```bash
# Méthode 1 : Command line
mysql -h localhost -u root -p0000 -e "CREATE DATABASE novashop_db"

# Méthode 2 : PhpMyAdmin
# Créer DB "novashop_db" manuellement
```

#### 5. Import du schéma

```bash
# Importer setup.sql
mysql -h localhost -u root -p0000 novashop_db < setup.sql

# Ou copier-coller via PhpMyAdmin
```

#### 6. Installation dépendances (optionnel)

```bash
composer install
```

#### 7. Lancer le serveur

```bash
# À partir du répertoire du projet
php -S localhost:8000 -t Public Public/router.php
```

**Output** :
```
[Wed Feb 05 12:00:00 2026] PHP 7.4.x Development Server started
[Wed Feb 05 12:00:00 2026] Listening on http://localhost:8000
```

#### 8. Vérifier installation

```
http://localhost:8000/
# Should show : NovaShop homepage
```

### Dépannage

**Erreur : "Connection refused to MySQL"**
```
Vérifier credentials dans App/Config/env.php
Vérifier que MySQL server est running
```

**Erreur : "Unknown column 'is_active'"**
```
Exécuter scripts de migration :
php scripts/add_is_active_column.php
php scripts/add_variants_column.php
php scripts/add_email_verified_at_column.php
```

**Erreur : "Image upload failed"**
```
Vérifier permissions dossier :
chmod 755 Public/Assets/Images/products/
```

---

## Documentation d'utilisation

### Pour les utilisateurs finaux

#### Accès public

**Accueil** : `http://localhost:8000/`
- Vue d'ensemble de la boutique
- Navigation vers catalogue

**Catalogue** : `/products`
- Listing tous produits
- Recherche par mot-clé
- Filtrage catégories

**Détail produit** : `/product/{id}`
- Description complète
- Prix et stock
- Variantes disponibles
- Bouton "Ajouter au panier"

**Panier** : `/cart`
- Affichage articles
- Modification quantités
- Calcul total TTC
- Bouton "Valider commande"

#### Authentification

**Inscription** : `/register`
```
1. Remplir : nom, email, mot de passe
2. Validation email unique + mdp ≥ 6 caractères
3. Compte créé immédiatement
4. Redirection vers login
```

**Connexion** : `/login`
```
1. Remplir : email, mot de passe
2. Vérification credentials
3. Session créée
4. Redirection vers accueil
```

**Mot de passe oublié** : `/forgot`
```
1. Entrer email
2. Lien réinitialisation envoyé (dev mode : console)
3. Cliquer lien → `/reset-password?token=...`
4. Entrer nouveau mot de passe
```

#### Commandes

**Historique** : `/orders`
- Liste de mes commandes
- Statuts (pending, shipped, delivered)
- Détail (articles, prix, total)

**Suivi commande** : `/order/{id}`
- Statut actuel
- Articles commandés
- Total
- Dates

**Profil** : `/profile`
- Informations personnelles
- Adresse email
- Paramètres compte

### Pour les administrateurs

**Accès** : `/admin` (réservé rôle admin/super_admin)

#### Dashboard

Affiche statistiques :
- Nombre utilisateurs
- Nombre produits
- Nombre commandes

#### Gestion utilisateurs

**URL** : `/admin/users`

**Opérations** :
1. **Voir liste** : Tous utilisateurs avec triage
   - Colonne : Nom, Email, Rôle, Statut, Actions
   - Tri cliquable : par nom, rôle, date

2. **Modifier rôle**
   ```
   Cliquer "Modifier" → Dropdown rôle
   → user | moderator | admin | super_admin
   → Sauvegarder
   ```

3. **Désactiver compte**
   ```
   Cliquer "Désactiver"
   → Utilisateur ne peut plus se connecter
   → is_active = FALSE
   ```

4. **Réactiver compte**
   ```
   Cliquer "Réactiver"
   → is_active = TRUE
   ```

5. **Supprimer utilisateur**
   ```
   Cliquer "Supprimer"
   → Demande confirmation
   → Suppression des commandes associées
   ```

#### Gestion produits

**URL** : `/admin/products`

**Opérations** :

1. **Créer produit**
   ```
   Formulaire :
   - Nom*
   - Description
   - Prix*
   - Categorie*
   - Stock*
   - Variantes (ex: S, M, L, XL)
   - Image (upload)
   
   → Soumettre
   ```

2. **Éditer produit**
   ```
   Cliquer "Éditer" sur produit
   → Formulaire pré-rempli
   → Modifier champs
   → Soumettre
   ```

3. **Supprimer produit**
   ```
   Cliquer "Supprimer"
   → Demande confirmation
   → Produit supprimé
   ```

4. **Upload image**
   ```
   Types acceptés : JPG, PNG, WEBP, GIF
   Taille max : 5 MB
   → Sauvegardé en /Public/Assets/Images/products/
   ```

#### Gestion commandes

**URL** : `/admin/orders`

**Opérations** :

1. **Voir commandes**
   - Liste toutes commandes
   - Tri par date, statut, utilisateur

2. **Changer statut**
   ```
   Cliquer commande
   → Dropdown statut :
      pending → confirmed → shipped → delivered
                         ↓
                      cancelled
   → Sauvegarder
   ```

3. **Voir détail**
   ```
   Cliquer numéro commande
   → Articles (produit, quantité, prix)
   → Total commande
   → Date et statut
   ```

### Rôles et permissions

| Action | User | Moderator | Admin | Super_Admin |
|--------|------|-----------|-------|------------|
| Voir catalogue | ✓ | ✓ | ✓ | ✓ |
| Passer commande | ✓ | ✓ | ✓ | ✓ |
| Voir mes commandes | ✓ | ✓ | ✓ | ✓ |
| Tableau de bord admin | ✗ | ✓ | ✓ | ✓ |
| Gérer utilisateurs | ✗ | ✓ | ✓ | ✓ |
| Gérer produits | ✗ | ✗ | ✓ | ✓ |
| Gérer rôles | ✗ | ✗ | ✓ | ✓ |
| Gérer commandes | ✗ | ✓ | ✓ | ✓ |
| Changer rôle super_admin | ✗ | ✗ | ✗ | ✓ |

---

## Maintenance et outils

### Scripts de maintenance

#### Vérification images produits
```bash
php scripts/check_product_images.php
```
Affiche :
- Statut chaque image (exists/missing/external)
- Chemin fichier
- URL en base de données

#### Réparation images manquantes
```bash
# Dry-run
php scripts/repair_missing_images.php

# Apply changes
php scripts/repair_missing_images.php --apply
```
Actions :
- Détecte images manquantes/externes
- Télécharge placeholders picsum.photos
- Met à jour `products.image_url`

#### Tests unitaires
```bash
php scripts/test_registration.php
php scripts/test_registration_http.php
php scripts/test_product_edit.php
```
Valident :
- Création utilisateur
- Vérification données
- Édition produit

### Logging

Logs stockés en `/logs/` :
- `user_delete.log` : Suppression utilisateurs
- `error.log` : Erreurs générales

### Performance et optimisations

**Indices base de données** :
- users.email (recherche rapide connexion)
- users.role (filtrage admin)
- orders.user_id (commandes utilisateur)
- products.category_id (filtrage)

**Recherche FULLTEXT** :
- Index : products(name, description)
- Recherche rapide catalogue

**Session PHP** :
- Stockage en fichier (par défaut)
- Upgrade : Redis/Memcached pour scale

### Considérations sécurité supplémentaires

Pour une utilisation production :

1. **HTTPS obligatoire**
   ```
   Rediriger HTTP → HTTPS
   Set-Cookie with Secure flag
   ```

2. **Rate limiting**
   ```
   Limiter tentatives login (5/min)
   Limiter API endpoints
   ```

3. **WAF (Web Application Firewall)**
   ```
   Detecter injections SQL, XSS
   Bloquer bots malveillants
   ```

4. **Monitoring**
   ```
   Logs centralisés
   Alertes sur erreurs
   Dashboard surveillance
   ```

5. **Backup automatique**
   ```
   Base données : quotidien
   Fichiers : versioning (Git)
   ```

---

## Conclusion

NovaShop Pro démontre une architecture web professionnelle avec :

✅ **Robustesse** : Gestion erreurs, validation input, contrôle accès  
✅ **Sécurité** : BCRYPT, prepared statements, CSRF protection  
✅ **Maintenabilité** : Code modulaire, pattern MVC, documentation  
✅ **Scalabilité** : BD relationnelle, indices optimisés, design extensible  
✅ **UX** : Interface responsive, navigation intuitive  

Le projet peut servir comme base pour :
- Plateforme e-commerce réelle
- Étude architecture web
- Portfolio candidature développeur

---

**Date** : 5 février 2026  
**Auteur** : Équipe NovaShop  
**Version** : 1.0 Pro
