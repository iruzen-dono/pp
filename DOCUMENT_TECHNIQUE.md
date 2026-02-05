# DOCUMENT TECHNIQUE - Résumé décision et architecture

## Résumé exécutif pour présentation

### 1. Qu'est-ce que NovaShop Pro ?

**NovaShop Pro** est une **plateforme de commerce électronique full-stack** développée en **PHP natif** (sans framework externe) suivant le pattern architectural **MVC**.

**Objectifs du projet** :
- Démontrer l'architecture web moderne
- Implémenter les meilleures pratiques PHP
- Gérer la complexité métier (panier, commandes)
- Assurer la sécurité applicative
- Offrir une UX professionnelle

### 2. Stack technologique

```
┌─────────────────────────────────────────┐
│         FRONTEND                        │
├─────────────────────────────────────────┤
│ HTML5 | CSS3 | Bootstrap 5 | JS         │
└──────────────────────┬────────────────────┘
                       │
                  HTTP/HTTPS
                       │
┌──────────────────────┴────────────────────┐
│         BACKEND (PHP 7.4+)                │
├─────────────────────────────────────────┤
│ App/Core/App.php (Bootstrap)            │
│ App/Core/Router.php (Dispatcher)        │
│ App/Controllers/* (Business Logic)      │
│ App/Models/* (Data Access)              │
│ App/Middleware/* (Security)             │
└──────────────────────┬────────────────────┘
                       │
                    PDO
                       │
┌──────────────────────┴────────────────────┐
│         DATABASE (MySQL 5.7+)            │
├─────────────────────────────────────────┤
│ 5 tables principales                    │
│ Indices optimisés                       │
│ Intégrité référentielle                 │
└─────────────────────────────────────────┘
```

### 3. Pourquoi PHP natif (pas de framework) ?

**Avantages** :
1. **Pédagogique** : Voir tous les concepts (routing, MVC, sécurité)
2. **Léger** : ~500 lignes code core, pas de dépendances lourdes
3. **Contrôle complet** : Pas d'abstraction masquée
4. **Performance** : Pas de boilerplate framework

**Inconvénient** :
- Code à réinventer vs Laravel/Symfony prêt-à-l'emploi

### 4. Architecture MVC en pratique

```
Utilisateur clique "Ajouter au panier"
           ↓
    URL : POST /cart/add?product_id=5
           ↓
    Router.php parse URL → CartController
           ↓
   CartController->add()
    • Valide requête
    • Appelle Product->getById(5)
    • Vérifie stock
           ↓
   Session['cart'][5] = [qty, price, variant]
           ↓
   Redirect /cart
           ↓
   CartController->index()
   • Calcule total
   • Passe à View
           ↓
   View affiche HTML panier
           ↓
   Navigateur affiche page
```

### 5. Sécurité : Comment on protège ?

#### A. Injection SQL
```php
❌ MAUVAIS
$sql = "SELECT * FROM users WHERE email = '$email'";
// Attaque : email = "admin'--" → accès admin

✅ BON (Prepared Statement)
$stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]); // PDO échappe automatiquement
```

#### B. Mot de passe
```php
// Hash BCRYPT avec salt aléatoire
password_hash($password, PASSWORD_BCRYPT);
// Résistant brute force (long à calculer)
```

#### C. CSRF (Cross-Site Request Forgery)
```html
<!-- Token dans formulaire -->
<input type="hidden" name="csrf_token" value="<?= session_id() ?>">

// Vérification côté serveur
if ($_SESSION['csrf_token'] !== $_POST['csrf_token']) {
    die("Attaque CSRF détectée");
}
```

#### D. XSS (Cross-Site Scripting)
```php
❌ MAUVAIS
<h1><?= $product['name'] ?></h1>
<!-- Si name = "<script>alert('XSS')</script>" → exécute JS -->

✅ BON
<h1><?= htmlspecialchars($product['name']) ?></h1>
<!-- Chaîne affichée littéralement -->
```

#### E. Session
```php
// À la connexion
session_regenerate_id(true); // Nouveau session ID
$_SESSION['user'] = [id, name, email, role];

// Vérification (middleware)
if (!isset($_SESSION['user'])) {
    header("Location: /login");
}
```

### 6. Modèle données (Schéma simplifié)

```
USERS (1)
    ↓ (N)
ORDERS (1)
    ↓ (N)
ORDER_ITEMS → PRODUCTS
                ├→ CATEGORIES

users.id = PK (1-100)
orders.user_id = FK → users.id
order_items.order_id = FK → orders.id
order_items.product_id = FK → products.id
products.category_id = FK → categories.id
```

**Indices** (optimisations) :
- users.email (accès login rapide)
- orders.user_id (requête commandes utilisateur)
- products (FULLTEXT search sur name+description)

### 7. Rôles et permissions

```
         Utilisateur
           Login
             ↓
        ┌─────┬─────┬─────┬──────────┐
        ↓     ↓     ↓     ↓          ↓
       user moder admin  super_admin
                         (tous droits)
```

| Fonctionnalité | User | Moderator | Admin | Super_admin |
|---|---|---|---|---|
| Voir catalogue | ✓ | ✓ | ✓ | ✓ |
| Admin dashboard | ✗ | ✓ | ✓ | ✓ |
| Gérer users | ✗ | ✓ | ✓ | ✓ |
| Gérer rôles | ✗ | ✗ | ✓ | ✓ |
| Super_admin actions | ✗ | ✗ | ✗ | ✓ |

### 8. Fonctionnalités principales

#### 8.1 Authentification
- Enregistrement (email unique, bcrypt password)
- Connexion (vérification credentials)
- Réinitialisation mot de passe (token 24h)
- Middleware pour protéger routes

#### 8.2 Catalogue
- 35 produits exemples
- Recherche FULLTEXT
- Variantes (tailles, couleurs, capacités)
- Upload images (validation MIME + taille)

#### 8.3 Panier
- Stockage session PHP
- Gestion variantes
- Calcul total automatique
- Persistent pendant session

#### 8.4 Commandes
- Création depuis panier
- Statuts : pending → confirmed → shipped → delivered
- Historique utilisateur
- Suivi détail + articles

#### 8.5 Admin Panel
- CRUD produits
- CRUD utilisateurs
- Gestion commandes
- Gestion rôles (super_admin)

### 9. Décisions architecturales justifiées

#### Q1. Pourquoi MVC et pas autre pattern ?
```
MVC = Model-View-Controller
• Model : accès données (Product, Order, User)
• View : présentation (HTML templates)
• Controller : logique métier (validation, orchestration)

Avantages :
✓ Séparation responsabilités
✓ Testabilité
✓ Maintenabilité (bug dans quoi ? Model=data, View=affichage, Ctrl=logique)
```

#### Q2. Session ou JWT pour authentification ?
```
Session choisi car :
✓ Côté serveur (sûr)
✓ Pas d'export données sensibles (token)
✓ Simpler que JWT pour CRUD simple
⚠️ JWT meilleur pour API microservices distants
```

#### Q3. Base données relationnelle ou NoSQL ?
```
SQL (MySQL) choisi car :
✓ Relations (commandes→items→produits)
✓ Intégrité référentielle (DELETE cascade)
✓ Transactions (atomicité)
⚠️ NoSQL meilleur pour gros volume non-structurés
```

#### Q4. Pourquoi PDO et pas MySQLi ?
```
PDO choisi car :
✓ Abstraction DB (changer driver futur)
✓ Prepared statements sécurisés
✓ Gestion erreurs uniforme
```

### 10. Métriques de qualité

```
Code Structure :
├─ Lignes code Core : ~500 (Core/Model.php, Core/Router.php)
├─ Lignes contrôleurs : ~1500
├─ Lignes modèles : ~800
├─ Lignes vues : ~2000
└─ TOTAL : ~5000-6000 lignes

Sécurité :
✓ Prepared statements (100% injection SQL prevention)
✓ Bcrypt passwords
✓ CSRF tokens
✓ XSS htmlspecialchars()
✓ Session regeneration

Performance :
✓ Indices BD optimisés
✓ FULLTEXT search efficace
✓ Pas N+1 queries
✓ Session stockage léger

Maintenabilité :
✓ Code commenté
✓ Erreurs explicites
✓ Logs (user_delete.log, error.log)
✓ MVC séparation
✓ Migrations (scripts/)
```

### 11. Dépendances (Composer)

```json
{
  "require": {
    "php": ">=7.4"
  },
  "require-dev": {
    "phpunit/phpunit": "^9.5",     // Tests
    "phpstan/phpstan": "^1.9",     // Static analysis
    "squizlabs/php_codesniffer": "^3.7"  // Code style
  }
}
```

**Minimaliste** = seulement ce qui est nécessaire

### 12. Considérations futures (Améliorations possibles)

```
Court terme :
☐ Email réel (SwiftMailer) - actuellement mock
☐ Pagination produits (200+ articles)
☐ Filtrage avancé (prix, variante)
☐ Codes promo / Promotions

Moyen terme :
☐ Paiement intégré (Stripe, PayPal)
☐ API REST (clients mobiles)
☐ Cache (Redis)
☐ Admin export Excel commandes

Long terme :
☐ Migration LaravelrPHP-FIG standards
☐ Tests unitaires complets
☐ Admin analytics (charts)
☐ Internationalization (i18n)
☐ Microservices (inventory, payment)
```

### 13. Fichiers importants pour examen

```
LECTURE RECOMMANDÉE (dans cet ordre) :

1. Setup.sql
   → Comprendre schéma BD
   
2. App/Core/Model.php (30 lignes)
   → Pattern base classes modèles
   
3. App/Core/Router.php (60 lignes)
   → Dispatcher URLs
   
4. App/Controllers/AuthController.php
   → Authentification complète
   
5. App/Controllers/CartController.php
   → Session management
   
6. App/Models/Order.php
   → Relations complexes
   
7. App/Middleware/AdminMiddleware.php
   → Contrôle accès
   
POINTS À MONTRER :
✓ Prepared statements (Model.php, ligne 8)
✓ Bcrypt (AuthController, ligne 35)
✓ Session (AuthController, ligne 90)
✓ CSRF (Middleware/CsrfMiddleware.php)
✓ Router (Core/Router.php - dispatch)
```

### 14. Questions probables du professeur

#### Q. "Pourquoi pas utiliser Laravel ?"
```
Réponse : 
Ce projet a pour but d'enseigner l'architecture web.
Avec Laravel (framework), beaucoup caché → apprentissage !
Ici, tout explicite → voir patterns MVC, sécurité, routing.
```

#### Q. "Comment ça scale pour 1M utilisateurs ?"
```
Réponse :
Optimisations nécessaires :
1. Cache → Redis (sessions, requests)
2. CDN → Images (AWS CloudFront)
3. Load Balancing → Plusieurs serveurs
4. DB Replication → Master/Slave
5. Logs centralisé → ELK Stack
Le code actuel = fondation solide pour scale !
```

#### Q. "Les images utilisent quel service ?"
```
Réponse :
Actuellement : Local file system + picsum.photos (placeholders)
Production : S3 (AWS), GCP Storage, Azure Blob
Avantage déploiement local : pas API key besoin
```

#### Q. "Comment gérer les pannes ?"
```
Réponse :
1. Logs détaillés (errors.log)
2. Monitoring (uptime robot)
3. Backup BD quotidiens
4. Failover database (MySQL replica)
5. Circuit breaker (log erreurs, pause requêtes)
```

#### Q. "Sécurité : niveau production ?"
```
Réponse :
Implémenté ✓ :
- Prepared statements
- Bcrypt passwords
- CSRF tokens
- XSS protection
- Session security
- Input validation

À ajouter pour prod ✓ :
- HTTPS obligatoire
- Rate limiting
- WAF (CloudFlare)
- DDoS protection
- Secrets gérés (env vars)
- 2FA optional
```

### 15. Résumé pour mémoire / rapport

```
TITRE : NovaShop Pro - Plateforme E-commerce en PHP Natif

CONTEXTE :
Projet académique d'architecture web moderne

TECHNOLOGIES :
- Backend : PHP 7.4+ natif (sans framework)
- Frontend : HTML5, CSS3, Bootstrap 5
- Database : MySQL 5.7+
- Patterns : MVC, Singleton (DB), Middleware

FONCTIONNALITÉS CLÉS :
✓ Authentification sécurisée (BCRYPT)
✓ Catalogue produits (35 items, variantes)
✓ Panier persistant (session)
✓ Gestion commandes (workflow)
✓ Panel admin (CRUD)
✓ Rôles & permissions (user/moderator/admin/super_admin)

SÉCURITÉ :
✓ Injection SQL (Prepared Statements)
✓ Passwords (BCRYPT)
✓ CSRF (tokens)
✓ XSS (htmlspecialchars)
✓ Authentification (sessions)

ARCHITECTURE :
MVC séparation claire :
- Models : données (5 tables)
- Views : templates (HTML)
- Controllers : logique métier

CODE : ~5000-6000 lignes PHP
TABLES BD : 5 (users, products, orders, order_items, categories)
ROUTES : 25+ endpoints

RÉSULTAT : Site e-commerce fonctionnel, sécurisé, maintenable
```

---

## Checklist présentation professeur

- [ ] Montrer site running : `php -S localhost:8000`
- [ ] Login utilisateur
- [ ] Parcourir catalogue /products
- [ ] Ajouter panier
- [ ] Passer commande
- [ ] Admin dashboard /admin
- [ ] Gérer produits (créer exemple)
- [ ] Upload image
- [ ] Gérer commandes
- [ ] Expliquer Router.php (dispatcher)
- [ ] Montrer Model.php (pattern)
- [ ] Expliquer sécurité (Prepared statements)
- [ ] Montrer schéma BD (setup.sql)
- [ ] Pointer des commits Git (si applicable)

---

## Document prêt à imprimer / rendre

```
📄 Fichiers à rendre :

1. RAPPORT_PROJET.md (90 pages)
   - Vue complète architecture
   - Chaque composant expliqué
   - Modèle données complet
   
2. GUIDE_UTILISATION.md (40 pages)
   - Tutoriels utilisateur
   - Tutoriels admin
   - Cas d'usage + dépannage
   
3. DOCUMENT_TECHNIQUE.md (cette page)
   - Résumé décisions
   - Architecture justifiée
   - Questions-réponses attendues
   
4. Démonstration live
   - Site fonctionnel
   - Parcours utilisateur complet
```

Bon courage pour la présentation ! 🎓
