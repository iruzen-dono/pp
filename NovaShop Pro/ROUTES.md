# 🗺️ GUIDE DES ROUTES - NovaShop Pro

Voici un guide détaillé pour utiliser chaque route de l'application.

---

## 🏠 ROUTES PUBLIQUES (Sans authentification)

### 1️⃣ Page d'accueil
```
URL: http://localhost:8000
ou
URL: http://localhost:8000/?url=home/index

Affiche: Page d'accueil avec features
Navigation: Lien vers produits, panier, connexion
```

---

## 👤 ROUTES D'AUTHENTIFICATION

### 2️⃣ Formulaire d'inscription
```
URL: http://localhost:8000/?url=auth/register
Méthode: GET

Affiche: Formulaire avec 3 champs
- Nom (text)
- Email (email)
- Mot de passe (password)

Bouton: S'inscrire (POST)
```

### 3️⃣ Valider une inscription
```
URL: http://localhost:8000/?url=auth/register
Méthode: POST

Données envoyées:
POST name=Jean Dupont
POST email=jean@novashop.com
POST password=SecurePass123

Action: Crée l'utilisateur en BDD
        Hash le mot de passe en bcrypt
        Redirige vers /auth/login

Vérifications:
- Email unique
- Données non vides
- Mot de passe hasché
```

### 4️⃣ Formulaire de connexion
```
URL: http://localhost:8000/?url=auth/login
Méthode: GET

Affiche: Formulaire avec 2 champs
- Email (email)
- Mot de passe (password)

Bouton: Se connecter (POST)
```

### 5️⃣ Valider une connexion
```
URL: http://localhost:8000/?url=auth/login
Méthode: POST

Données envoyées:
POST email=jean@novashop.com
POST password=SecurePass123

Vérifications:
1. Email existe en BDD?
2. Mot de passe correspond?
3. Vérification bcrypt

Résultats:
✅ OK: Crée $_SESSION['user'] + Redirige home
❌ Erreur: Affiche "Email ou mot de passe incorrect"
```

### 6️⃣ Déconnexion
```
URL: http://localhost:8000/?url=auth/logout
Méthode: GET

Action: session_destroy()
        Supprime $_SESSION['user']
        Redirige home

Résultat: Utilisateur anonyme
```

---

## 📦 ROUTES PRODUITS

### 7️⃣ Lister les produits
```
URL: http://localhost:8000/?url=products
Méthode: GET

Affiche: Liste de tous les produits
Colonnes:
- Nom du produit
- Description
- Prix
- Lien "Voir détails"

Données: SELECT * FROM products
Nombre: Tous les produits
```

### 8️⃣ Voir détails d'un produit
```
URL: http://localhost:8000/?url=products/show?id=1
Méthode: GET

Paramètres:
?id=1 (obligatoire)

Affiche:
- Nom du produit
- Description complète
- Prix
- Category ID
- Formulaire "Ajouter au panier"

Formulaire contient:
- Input hidden: product_id=1
- Input: quantity (défaut=1)
- Bouton: Ajouter au panier (POST)

Erreurs possibles:
- Produit inexistant: "❌ Produit non trouvé"
- Pas d'ID: Redirection vers /products
```

---

## 🛒 ROUTES PANIER

### 9️⃣ Voir le panier
```
URL: http://localhost:8000/?url=cart
Méthode: GET
Session requise: Non (mais recommandé)

Affiche: Contenu de $_SESSION['cart']

Si vide:
- Message "Votre panier est vide"
- Lien "Continuer vos achats"

Si produits:
- Tableau avec produit_id + quantité
- Bouton "Supprimer" pour chaque
- Bouton "Valider la commande"

Structure $_SESSION['cart']:
[
  1 => 2,    // Product ID 1, Quantité 2
  3 => 1,    // Product ID 3, Quantité 1
]
```

### 🔟 Ajouter au panier
```
URL: http://localhost:8000/?url=cart/add
Méthode: POST

Données POST:
- product_id: "1" (obligatoire)
- quantity: "2" (défaut 1)

Action:
1. Crée $_SESSION['cart'] si absent
2. Si produit déjà en panier: ajoute la quantité
3. Si nouveau produit: l'ajoute

Exemple:
Avant: $_SESSION['cart'] = [1 => 2]
POST: product_id=1, quantity=3
Après: $_SESSION['cart'] = [1 => 5]

Redirection: /cart (GET)
```

### 1️⃣1️⃣ Retirer du panier
```
URL: http://localhost:8000/?url=cart/remove?id=1
Méthode: GET

Paramètres:
?id=1 (Product ID, obligatoire)

Action:
1. Vérifie si produit en panier
2. Supprime de $_SESSION['cart']

Exemple:
Avant: $_SESSION['cart'] = [1 => 2, 3 => 1]
?id=1
Après: $_SESSION['cart'] = [3 => 1]

Redirection: /cart (GET)
```

---

## 📋 ROUTES COMMANDES

### 1️⃣2️⃣ Lister mes commandes
```
URL: http://localhost:8000/?url=orders
Méthode: GET
Authentification: ✅ REQUISE

Vérification: AuthMiddleware::check()
Si non connecté: Redirection vers /login

Affiche: Toutes les commandes de l'utilisateur
Tableau:
- ID commande
- Total (€)
- Statut (pending, confirmed, shipped...)
- Date de création
- Lien "Détails"

Query: SELECT * FROM orders WHERE user_id=X

Données affichées:
- user_id (de la session)
- created_at (date)
- status (enum)
- total (DECIMAL)
```

### 1️⃣3️⃣ Voir détails d'une commande
```
URL: http://localhost:8000/?url=orders/show?id=1
Méthode: GET
Authentification: ✅ REQUISE

Paramètres:
?id=1 (Commande ID, obligatoire)

Vérifications:
1. Utilisateur connecté?
2. Commande existe?
3. Appartient à cet utilisateur?

Affiche (si OK):
- ID de la commande
- Total (€)
- Statut
- Date de création
- Lien "Retour aux commandes"

Erreurs:
- Pas connecté: Redirection /login
- ID manquant: Redirection /orders
- Commande inexistante: "❌ Commande non trouvée"
- Pas l'owner: "❌ Commande non trouvée"

Query: SELECT * FROM orders WHERE id=X
Vérif: order.user_id == SESSION.user.id
```

### 1️⃣4️⃣ Créer une commande
```
URL: http://localhost:8000/?url=orders/create
Méthode: GET ou POST
Authentification: ✅ REQUISE

GET: Affiche formulaire (optionnel, vue simple)

POST: Crée la commande
Action:
1. Insère: INSERT INTO orders (user_id, total, status)
           VALUES (SESSION.user.id, 0, 'pending')
2. Récupère lastInsertId()
3. Redirige vers /orders/show?id=X

Données créées:
- user_id: SESSION['user']['id']
- total: 0.00 (à calculer plus tard)
- status: 'pending'
- created_at: NOW()

Redirection: /orders/show?id=X (la nouvelle commande)

Note: Le panier n'est pas vidé (à implémenter)
```

---

## 👨‍💼 ROUTES ADMINISTRATION

### 1️⃣5️⃣ Dashboard admin
```
URL: http://localhost:8000/?url=admin/dashboard
Méthode: GET
Authentification: ✅ REQUISE
Permission: ✅ ADMIN SEULEMENT

Vérification: AdminMiddleware::check()
Conditions:
1. $_SESSION['user'] existe?
2. $_SESSION['user']['role'] == 'admin'?

Si OK:
Affiche: Dashboard avec links
- Gérer utilisateurs
- Gérer produits
- Voir commandes

Si erreur:
HTTP 403: "❌ Accès refusé : administrateur requis"

Devenir admin: 
UPDATE users SET role='admin' WHERE id=1;
```

### 1️⃣6️⃣ Gestion des utilisateurs
```
URL: http://localhost:8000/?url=admin/users
Méthode: GET
Permission: ✅ ADMIN SEULEMENT

Affiche: Liste des utilisateurs (à implémenter)
```

### 1️⃣7️⃣ Gestion des produits
```
URL: http://localhost:8000/?url=admin/products
Méthode: GET
Permission: ✅ ADMIN SEULEMENT

Affiche: Gestion CRUD produits (à implémenter)
```

### 1️⃣8️⃣ Gestion des commandes
```
URL: http://localhost:8000/?url=admin/orders
Méthode: GET
Permission: ✅ ADMIN SEULEMENT

Affiche: Toutes les commandes (à implémenter)
```

---

## 🧪 ROUTES DIAGNOSTIC

### 1️⃣9️⃣ Diagnostic système
```
URL: http://localhost:8000/diagnostic.php
Méthode: GET
Authentification: Non requise

Affiche:
✅ Version PHP
✅ Extensions installées
✅ Fichiers du projet
✅ Permissions
✅ Connexion BDD
✅ Tables présentes
✅ Configuration système

Utilité: Troubleshooting et vérification
```

---

## 📊 Résumé des routes

| # | Route | Méthode | Auth | Permission | Status |
|---|-------|---------|------|-----------|--------|
| 1 | / | GET | ❌ | - | ✅ |
| 2 | auth/register | GET | ❌ | - | ✅ |
| 3 | auth/register | POST | ❌ | - | ✅ |
| 4 | auth/login | GET | ❌ | - | ✅ |
| 5 | auth/login | POST | ❌ | - | ✅ |
| 6 | auth/logout | GET | ✅ | - | ✅ |
| 7 | products | GET | ❌ | - | ✅ |
| 8 | products/show | GET | ❌ | - | ✅ |
| 9 | cart | GET | ❌ | - | ✅ |
| 10 | cart/add | POST | ❌ | - | ✅ |
| 11 | cart/remove | GET | ❌ | - | ✅ |
| 12 | orders | GET | ✅ | - | ✅ |
| 13 | orders/show | GET | ✅ | - | ✅ |
| 14 | orders/create | POST | ✅ | - | ✅ |
| 15 | admin/dashboard | GET | ✅ | admin | ✅ |
| 16 | admin/users | GET | ✅ | admin | ⏳ |
| 17 | admin/products | GET | ✅ | admin | ⏳ |
| 18 | admin/orders | GET | ✅ | admin | ⏳ |
| 19 | diagnostic.php | GET | ❌ | - | ✅ |

---

## 🔑 Légende

| Symbole | Signification |
|---------|--------------|
| ✅ | Implémenté et testé |
| ⏳ | À implémenter |
| GET | Afficher un formulaire/liste |
| POST | Traiter les données |
| ✅ Auth | Authentification requise |
| ❌ Auth | Anonyme autorisé |
| admin | Permission admin requise |
| - | Aucune permission spéciale |

---

## 💡 Exemples d'utilisation

### Scénario complet

```
1. Utilisateur accès homepage
   URL: http://localhost:8000
   ↓

2. Clique "Produits"
   URL: http://localhost:8000/?url=products
   ↓

3. Clique "Voir détails" sur Laptop Pro
   URL: http://localhost:8000/?url=products/show?id=1
   ↓

4. Ajoute 2 au panier (POST)
   URL: http://localhost:8000/?url=cart/add
   Redirection: http://localhost:8000/?url=cart
   ↓

5. Voit le panier
   URL: http://localhost:8000/?url=cart
   ↓

6. Clique "Valider commande" (POST)
   URL: http://localhost:8000/?url=orders/create
   Redirection: http://localhost:8000/?url=orders/show?id=1
   ↓

7. Voit sa commande
   URL: http://localhost:8000/?url=orders/show?id=1
   ↓

8. Se déconnecte
   URL: http://localhost:8000/?url=auth/logout
   Redirection: http://localhost:8000
```

---

**Tous les chemins pour explorer NovaShop Pro! 🗺️**
