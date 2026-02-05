# GUIDE D'UTILISATION DÉTAILLÉ - NovaShop Pro

## Table des matières
1. [Guide utilisateur](#guide-utilisateur)
2. [Guide administrateur](#guide-administrateur)
3. [Cas d'usage courants](#cas-dusage-courants)
4. [Dépannage](#dépannage)

---

## GUIDE UTILISATEUR

### Pour débuter

#### 1ère visite : Inscription

```
1. Accéder à http://localhost:8000/register
2. Remplir les champs :
   - NOM COMPLET : ex "Jean Dupont"
   - EMAIL : ex "jean.dupont@email.com"
   - MOT DE PASSE : min 6 caractères
   - CONFIRMER MOT DE PASSE : même valeur

3. Cliquer "S'inscrire"
4. Message de succès → "Compte créé avec succès"
5. Redirection automatique vers login

✓ Compte créé et prêt à l'emploi
```

#### Connexion

```
1. Accéder à http://localhost:8000/login
2. Remplir :
   - EMAIL : ex "jean.dupont@email.com"
   - MOT DE PASSE : votre mot de passe

3. Cliquer "Connexion"
4. Redirection vers page d'accueil

✓ Vous êtes connecté
```

**Indicateurs visuels** :
- Barre navigation affiche votre nom
- Bouton "Déconnexion" visible
- Menu "Mes commandes", "Profil"

### Navigation dans le catalogue

#### Parcourir les produits

**Page produits** : `/products`

```
1. Cliquer "Produits" dans menu
2. Voir liste de tous produits disponibles
3. Chaque produit affiche :
   - Thumbnail image
   - Nom du produit
   - Prix
   - Stock disponible
```

#### Rechercher un produit

```
1. Sur page produits en haut : barre de recherche
2. Taper un mot-clé :
   - ex "MacBook" → produits Apple
   - ex "Blanc" → tous produits blancs
   - ex "L" → tailles L, produits avec L
3. Résultats :
   - ✓ Recherche par nom ET description
   - Permet trouver facilement

Note : Recherche insensible à la casse
```

#### Voir détail d'un produit

```
1. Cliquer sur un produit → Page détail
2. Affichage complet :
   - Grande image
   - Nom + Description complète
   - Prix unitaire en gras
   - Stock (en stock / rupture)
   - Variantes disponibles (si existantes)

3. Variantes : Sélectionner option
   - Exemple : Taille → S / M / L / XL
   - Exemple : Couleur → Noir / Blanc / Bleu
   - Chaque combinaison = prix différent potentiellement

4. Quantité : Choisir combien
5. Bouton "AJOUTER AU PANIER"
```

### Gestion du panier

#### Ajouter au panier

```
Depuis page détail produit :

1. Sélectionner variante (si applicable)
   - Cliquer dropdown
   - Choisir option
   
2. Entrer quantité (défaut 1)
   - Cliquer +/- ou saisir nombre
   
3. Cliquer "Ajouter au panier"
4. Message de confirmation : "✓ Produit ajouté"
```

#### Consulter le panier

```
1. Cliquer "Panier" en haut-droit (ou menu)
2. URL : /cart

Affichage :
- Tableau avec articles
- Colonnes : Produit | Variante | Quantité | Prix unit. | Sous-total
- Ligne TOTAL en bas (Sous-total + TVA = Total TTC)

Actions possibles :
- Modifier QUANTITÉ : champ +/- sur chaque ligne
- SUPPRIMER article : bouton ✕
- VIDER panier : bouton "Vider"
```

#### Modifier panier avant commande

```
Ajuster les quantités :

1. Sur chaque ligne, champ quantité
2. Modifier nombre
3. Auto-calcul du nouveau sous-total

Retirer produit :

1. Cliquer bouton "Supprimer" ligne
2. Produit retiré
3. Total recalculé automatiquement

Continuer shopping :

1. Cliquer "Continuer shopping"
2. Retour catalogue
3. Panier conservé
```

### Passer commande

#### De la sélection au paiement

```
1. Panier rempli → Cliquer "VALIDER COMMANDE"
2. Vérification :
   - Affichage résumé articles
   - Montant total TTC
   - Adresse livraison (utilisateur actuel)

3. Confirmation :
   - Cliquer "CONFIRMER COMMANDE"
   - Commande créée en base
   - ID commande généré
   - Statut initial : "Pending"

✓ Commande enregistrée !
```

#### Historique et suivi

**Page commandes** : `/orders`

```
Voir mes commandes :

1. Connecté → Menu "Mes commandes"
2. Liste chronologique :
   - Numéro commande
   - Date passation
   - Total
   - Statut actuel

Cliquer numéro → Page détail
```

**Détail commande** : `/order/{id}`

```
Affichage complet :

- En-tête :
  * Numéro commande
  * Date passation
  * Statut : PENDING / CONFIRMED / SHIPPED / DELIVERED / CANCELLED

- Tableau articles :
  * Produit | Quantité | Variante | Prix unit. | Sous-total
  
- Total commande (TTC)

- Suivi :
  * ⭕ Pending (en attente confirmation)
  * ⭕ Confirmed (validée)
  * ⭕ Shipped (expédiée)
  * ⭕ Delivered (livrée) ← Final

Note : Actualiser page pour voir mise à jour
```

### Profil utilisateur

#### Consulter profil

**URL** : `/profile`

```
1. Cliquer "Profil" en menu
2. Affichage informations :
   - Nom complet
   - Email
   - Rôle (user, admin, etc)
   - Nombre commandes
   - Dernier achat

3. Liens rapides :
   - Voir mes commandes
   - Modifier paramètres
   - Changer mot de passe
```

#### Paramètres compte

**URL** : `/settings`

```
Disponible (si implémenté) :
- Modifier email
- Modifier mot de passe
- Préférences notifications
- Adresse livraison par défaut
- Adresse facturation
```

### Mot de passe oublié

**Processus de récupération** :

```
1. Page login → Cliquer "Mot de passe oublié ?"
2. URL : /forgot

3. Formulaire :
   - Entrer EMAIL
   - Cliquer "Envoyer lien"

4. Message :
   "Si un compte existe, email envoyé"
   (message générique pour sécurité)

5. Vérifier email :
   - Lien réinitialisation envoyé
   - Valable 24h

6. Cliquer lien email :
   - Redirection /reset-password?token=xxxxx
   - Formulaire nouveau mot de passe
   - Confirmation
   - Cliquer "Réinitialiser"

✓ Mot de passe changé
   Reconnexion ensuite
```

---

## GUIDE ADMINISTRATEUR

### Accès panel admin

#### Authentification admin

```
Prérequis : Compte avec rôle ADMIN

1. Connexion normale : /login
2. Après success :
3. Naviguer vers /admin/dashboard
4. OU attendre : Super_admin définit votre rôle → admin

Si message "Accès refusé" :
→ Rôle insuffisant
→ Demander élévation rôle à super_admin
```

#### Dashboard

**URL** : `/admin` ou `/admin/dashboard`

```
Vue d'ensemble :

- Statistiques clés en haut :
  * 👥 Nombre utilisateurs
  * 📦 Nombre produits
  * 📋 Nombre commandes

- Liens rapides :
  * Gérer utilisateurs
  * Gérer produits
  * Gérer commandes
  * Voir statistiques

- Historique recent :
  * Derniers utilisateurs créés
  * Derniers produits ajoutés
  * Dernières commandes
```

### Gestion utilisateurs

#### Accéder page utilisateurs

**URL** : `/admin/users`

```
Menu admin → "Utilisateurs"
Ou accès direct : http://localhost:8000/admin/users
```

#### Lister utilisateurs

```
Tableau affiche :
- ID | Nom | Email | Rôle | Statut | Actions

Tri cliquable :
- Cliquer entête colonne
- Croissant / Décroissant
- Affichage tri avec flèche ↑↓

Filtres disponibles :
- Par rôle : user, moderator, admin, super_admin
- Par statut : Actif, Désactivé
- Recherche nom/email
```

#### Modifier rôle utilisateur

```
1. Localiser utilisateur dans tableau
2. Cliquer "Modifier" → Dialog s'ouvre
3. Dropdown "Rôle" affiche :
   ☐ user (lecteur catalogue)
   ☐ moderator (gestion commandes)
   ☐ admin (gestion complète)
   ☐ super_admin (gestion rôles)

4. Sélectionner nouveau rôle
5. Cliquer "Confirmer"

✓ Rôle mis à jour
   (Utilisateur peut se reconnecter pour voir changement)

⚠️ Restrictions :
   - Admin NE peut pas enever rôle super_admin
   - Super_admin SEUL peut gérer super_admin
```

#### Désactiver / Réactiver compte

```
Désactiver (bloquer accès) :

1. Cliquer "Désactiver" sur utilisateur
2. Demande confirmation
3. Compte marqué inactif (is_active = FALSE)
4. Utilisateur reçoit message login : "Compte désactivé"

Réactiver (débloquer) :

1. Cliquer "Réactiver" sur utilisateur désactivé
2. is_active = TRUE
3. Utilisateur peut se reconnecter
```

#### Supprimer utilisateur

```
Avant : Vérifier impact !

1. Cliquer "Supprimer" utilisateur
2. Demande confirmation :
   "Êtes-vous sûr ? Ses commandes seront supprimées"

3. Réponses :
   - OUI → Suppression fichier
   - NON → Annulation

Cascade suppression :
- Email verification tokens
- Password reset tokens
- Commandes et articles associés
- Utilisateur supprimé définitivement

⚠️ IRRÉVERSIBLE - Ne pas tester en prod !
```

### Gestion produits

#### Accéder page produits

**URL** : `/admin/products`

```
Menu admin → "Produits"
Ou : http://localhost:8000/admin/products
```

#### Lister produits

```
Tableau affiche :
- ID | Image | Nom | Prix | Stock | Catégorie | Actions

Recherche :
- Barre en haut
- Mot-clé → Filtre nom/description
- Temps réel

Actions par produit :
- 👁 Voir
- ✏️ Éditer
- 🗑️ Supprimer
```

#### Créer un produit

**Bouton** "Ajouter produit" en haut

```
Formulaire complet :

1. NOM PRODUIT (required)
   - ex "MacBook Pro 16\" M3"

2. DESCRIPTION (textarea)
   - ex "Ordinateur portable haut de gamme...
      Écran Retina...
      Processeur M3 Max"

3. PRIX (required)
   - Decimal 10,2
   - Exemple : 2499.99

4. CATÉGORIE (required)
   - Dropdown : Électronique, Vêtements, Livres, Mobilier, etc
   - Créer catégorie si besoin en base

5. STOCK (required, défaut 0)
   - Nombres entiers
   - 0 = rupture de stock

6. VARIANTES (optionnel, text-area)
   - Format : Comma-separated
   - Exemple "S, M, L, XL"
   - Exemple "256GB, 512GB, 1TB"
   - Exemple "Noir, Blanc, Gris"

7. IMAGE (optionnel)
   - Formats : JPEG, PNG, WEBP, GIF
   - Taille max : 5 MB
   - Upload automatique → Public/Assets/Images/products/

8. Bouton CRÉER
   ✓ Produit ajouté avec ID généré
```

#### Éditer un produit

**Processus** :

```
1. Cliquer "Éditer" sur produit
2. URL : /admin/products/edit/{id}
3. Formulaire pré-rempli avec données existantes

4. Modifications possibles :
   - Nom
   - Description
   - Prix
   - Catégorie
   - Stock
   - Variantes (ajouter/retirer options)
   - Image (remplacer)

5. Cliquer "METTRE À JOUR"
   ✓ Changement enregistré en base
```

**Cas courant : Mise à jour stock**

```
1. Produit reçu 10 unités supplément
2. Éditer produit
3. Champ "Stock" : modifier nombre
4. Sauvegarder
5. Clients voient stock à jour sur catalogue
```

#### Supprimer un produit

```
1. Cliquer "Supprimer" produit
2. Confirmation "Êtes-vous sûr ?"
3. Réponses :
   - OUI → Produit supprimé
   - NON → Annulation

Inévitabilités :
- Produit disparaît du catalogue
- Image associée supprimée
- Clients voient plus le produit
- Commandes existantes conservées (références)

⚠️ Attention : Commandes existantes restent intactes
    mais produit plus disponible à la vente
```

#### Upload d'image

**Lors création/édition** :

```
1. Upload depuis ordinateur
   - Cliquer "Choisir fichier"
   - Sélectionner image locale
   - Format : JPG, PNG, WEBP, GIF
   - Taille : max 5 MB

2. Validation :
   - MIME type vérifié (pas .exe)
   - Taille vérifiée
   - Dimension recommandée : 500x500px

3. Sauvegarde :
   - Fichier copié → Public/Assets/Images/products/
   - Nom automatique : product_{id}_{random}.jpg
   - URL stockée en base

4. Affichage :
   - Catalogue montre thumbnail
   - Detail : image grande
```

### Gestion commandes

#### Accéder page commandes

**URL** : `/admin/orders`

```
Menu admin → "Commandes"
Ou : http://localhost:8000/admin/orders
```

#### Lister commandes

```
Tableau affiche :
- ID | Utilisateur | Date | Total | Statut | Actions

Filtres/Tri :
- Tri par date (récent en haut)
- Filtre statut : Pending, Confirmed, Shipped, Delivered, Cancelled
- Filtre utilisateur

Statuts codage couleur :
- 🔴 Pending (en attente)
- 🟠 Confirmed (confirmée)
- 🟡 Shipped (expédiée)
- 🟢 Delivered (livrée)
- ⚫ Cancelled (annulée)
```

#### Voir détail commande

**Cliquer numéro commande**

```
Affichage complet :

1. En-tête
   - Commande #12345
   - Client : Jean Dupont
   - Date : 2026-02-05 14:30
   
2. Articles commandés
   Tableau :
   - Produit | Variante | Quantité | Prix unit | Sous-total
   - Exemple :
     * MacBook Pro | 512GB | 1 | 2499.99 | 2499.99
     * Souris Logitech | Sans fil | 2 | 49.99 | 99.98
   
3. Total
   - Sous-total : XXXX.XX €
   - TVA (20%) : XXXX.XX €
   - TOTAL TTC : XXXX.XX €

4. Statut et actions
   - Statut : [PENDING ▼]
   - Dropdown pour changer
   - Bouton "Sauvegarder"
```

#### Modifier statut commande

**Progression** :

```
workflow commande :

┌─────────────┐
│   PENDING   │  (Commande reçue, non confirmée)
└─────┬───────┘
      ↓
┌─────────────┐
│ CONFIRMED   │  (Commande validée, en cours de prep)
└─────┬───────┘
      ↓
┌─────────────┐
│   SHIPPED   │  (Colis envoyé, en transit)
└─────┬───────┘
      ↓
┌─────────────┐
│ DELIVERED   │  (Reçu client, FIN)
└─────────────┘

      OU

      ↓ (annulation possible avant expédition)
┌─────────────┐
│ CANCELLED   │  (Commande annulée)
└─────────────┘
```

**Changement pratique** :

```
1. Cliquer commande
2. Champ "Statut" affiche option actuelle
3. Dropdown pour choisir nouveau statut
4. Cliquer "Mettre à jour"
5. Statut change en base
6. Client notifié automatiquement (si email configuré)
```

**Exemple scénario** :

```
09:00 → PENDING (cmd reçue)
10:00 → CONFIRMED (validée, paiement OK)
14:00 → SHIPPED (La Poste envoyé, n° suivi XXX)
+2j → DELIVERED (Client reçu)
```

#### Gestion rôles (admin avancé)

**URL** : `/admin/manage-roles`

```
Accès : Admin ou Super_admin SEUL

Affichage :
- Liste utilisateurs
- Rôle actuel : user, moderator, admin, super_admin
- Dropdown modification

Actions :
- user → moderator : Affichage commandes
- user → admin : Accès panel complet
- admin → super_admin : Gestion rôles (Super_admin SEUL)

Restriction :
- Admin ne peut pas DONNER rôle super_admin
- Admin peut retirer super_admin (dégradation)
- Super_admin peut tout faire

Raison : Sécurité (pas d'escalade rôle accidentelle)
```

---

## CAS D'USAGE COURANTS

### Scénario 1 : Nouveau client, première achat

```
ÉTAPES :

1. Client visite site
   → Parcours catalogue /products
   → Voir produit "Souris Logitech 99.99€"
   
2. Crée compte
   → /register
   → Email : newclient@domain.com
   → Password : MySecurePass2026
   
3. Se connecte
   → /login
   → Redirection accueil

4. Ajoute au panier
   → Click sur produit
   → Sélect variante "Noir, sans fil"
   → Quantité 1
   → "Ajouter au panier"

5. Ajoute second produit
   → Retour catalogue
   → Panier conservé (2/1 articles)
   → Second produit "Clavier mécanique"

6. Passe commande
   → /cart
   → Voir panier :
      * Souris noir : 1 × 99.99€
      * Clavier mécanique : 1 × 149.99€
      TOTAL : 249.98€ TTC
   
   → Cliquer "VALIDER COMMANDE"
   → Confirmation
   
   ✓ Commande #5847 créée
   
7. Suivi
   → /orders
   → Voir commande #5847
   → Statut : Pending
   
8. Admin traite
   → Voir dans /admin/orders
   → Confirme : CONFIRMED (validation paiement)
   → Marque SHIPPED (envoi La Poste)
   
9. Client suivit
   → /order/5847
   → Voir statut SHIPPED
   → (Actualiser après mise à jour)
   
10. Livraison
    → +2j admin marque DELIVERED
    → Client voit DELIVERED
    → Commande closée ✓
```

### Scénario 2 : Admin ajoute nouveau produit

```
ÉTAPES :

1. Admin logged in
   → /admin/products
   
2. Cliquer "Ajouter produit"
   → Formulaire vide
   
3. Remplissage :
   - Nom : "iPhone 15 Pro Max"
   - Description : "Dernier modèle Apple avec écran OLED..."
   - Prix : 1299.99
   - Catégorie : "Électronique"
   - Stock : 50 unités
   - Variantes : "Noir, Gris, Blanc / 256GB, 512GB, 1TB"
   
4. Upload image
   → Cliquer "Choisir fichier"
   → Sélect iphone15promax.jpg
   → Vérification taille (OK)
   
5. Créer
   → Cliquer "CRÉER"
   → Produit créé ID #152
   
✓ Produit visible dans catalogue
  Clients voir : iPhone 15..., 1299.99€, 50 dispo

6. Client achète
   → Ajoute au panier + variante
   → Commande traitée
```

### Scénario 3 : Gestion stock après vente

```
FLUX :

1. Produit en stock : 100 unités
2. Jour 1 : 20 clients achètent
   → Stock reste 100 (pas auto-update)
   
3. Admin log /admin/products
4. Cliquer "Éditer" produit
5. Stock : 100 → 80 (manuel adjustment)
6. Sauvegarder
7. Catalogue maj

Amélioration possible :
→ Auto-décrémente lors commande (future implémentation)
```

### Scénario 4 : Utilisateur oublie mot de passe

```
ÉTAPES :

1. Page login
   → Cliquer "Mot de passe oublié ?"
   → /forgot
   
2. Formulaire
   → Email input : "jean@example.com"
   → Cliquer "Envoyer"

3. Message
   → "Si email existe, lien envoyé"
   (Message générique → sécurité)

4. User vérif email
   → Lien : http://localhost:8000/reset-password?token=abc123xyz
   → Valable 24h

5. Page reset
   → Nouveau mot de passe : "NewPass2026"
   → Confirmation
   → Cliquer "Réinitialiser"

✓ Mot de passe changé
   Reconnexion /login avec nouveau mot de passe OK
```

### Scénario 5 : Admin désactive utilisateur problématique

```
CONTEXTE :
- User envoie commandes malveillantes
- Admin veut bloquer

ÉTAPES :

1. Admin → /admin/users
2. Localiser user problématique
3. Cliquer "Désactiver"
4. Confirmation "Êtes-vous sûr ?"
5. Click OUI

RÉSULTAT :
✓ is_active = FALSE
✓ Utilisateur tentant login :
   "Erreur : Compte désactivé"
✓ Ne peut plus passer commandes
✓ Commandes existantes intactes
✓ Admin peut réactiver si reconciliation

Avantage :
- Pas suppression définitive
- Historique conservé
- Réversible
```

---

## DÉPANNAGE

### Erreurs courantes et solutions

#### 01. "Impossible de créer le compte"

**Symptôme** : Formulaire register retourne erreur

**Causes possibles** :

1. Email déjà utilisé
   ```
   Solution : Utiliser email différent
   OU supprimer utiliateur existant /admin/users
   ```

2. Mot de passe trop court
   ```
   Minimum 6 caractères
   Solution : Augmenter longueur
   ```

3. Connexion base de données échouée
   ```
   Vérifier App/Config/env.php
   User/Pass MySQL corrects ?
   Database créé ?
   ```

**Debug** :
```bash
php scripts/test_registration.php
# Voir message erreur exact
```

---

#### 02. "Email ou mot de passe incorrect"

**Symptôme** : Impossible se connecter

**Causes** :

1. Email/mdp mauvais
   ```
   Solution : Vérifier orthographe
   Réinitialiser mdp ? /forgot
   ```

2. Compte désactivé
   ```
   Message exact : "Compte désactivé"
   Solution : Contacter admin pour réactivation
   ```

3. Utilisateur n'existe pas
   ```
   Solution : Créer compte /register
   ```

---

#### 03. "Accès refusé" (Admin)

**Symptôme** : Erreur 403 sur /admin

**Causes** :

1. Non connecté
   ```
   Solution : Se connecter /login d'abord
   ```

2. Rôle insuffisant (user, moderator)
   ```
   Solution : Contacter admin pour upgrade rôle
   Admin donne rôle "admin"
   ```

3. Super_admin seul pour /admin/manage-roles
   ```
   Solution : Utiliser super_admin ou demander
   ```

---

#### 04. Images produits disparues

**Symptôme** : Produits affichent "image non dispo"

**Causes** :

1. Fichier supprimé
   ```
   Vérifier /Public/Assets/Images/products/
   ```

2. Chemin incorrect en base
   ```
   Vérifier colonne products.image_url
   Doit être /Assets/Images/products/product_X.jpg
   ```

3. Upload image échouée
   ```
   Vérifier permissions dossier
   chmod 755 Public/Assets/Images/products/
   Vérifier taille image < 5MB
   Format : JPEG/PNG/WEBP/GIF
   ```

**Réparation automatique** :
```bash
php scripts/check_product_images.php
# Liste images manquantes

php scripts/repair_missing_images.php --apply
# Télécharge placeholders automatiquement
```

---

#### 05. Panier vide après navigation

**Symptôme** : Articles disparaissent du panier

**Causes** :

1. Session expirée
   ```
   Timeout ~ 30min inactivité
   Solution : Reconnecter et re-ajouter articles
   ```

2. Cookies désactivés
   ```
   Solution : Activer cookies dans navigateur
   ```

3. Navigateur différent
   ```
   Session/cookie local au navigateur
   Solution : Utiliser même navigateur
   ```

---

#### 06. "Erreur lors de la création du compte" (Admin)

**Symptôme** : Admin ne peut pas créer produit

**Causes** :

1. Stock invalide
   ```
   Doit être nombre entier ≥ 0
   Solution : Corriger valeur stock
   ```

2. Prix invalide
   ```
   Format : Decimal(10,2)
   Exemple : 99.99 OK, 99,99 KO
   Solution : Utiliser point (.)
   ```

3. Catégorie inexistante
   ```
   Solution : Créer catégorie en base d'abord
   INSERT INTO categories (name, description)
   ```

---

#### 07. Recherche produits ne retourne rien

**Symptôme** : /products?q=test → 0 résultats

**Causes** :

1. Produit n'existe pas
   ```
   Solution : Ajouter produit /admin/products
   ```

2. Mot-clé trop générique
   ```
   Solution : Ajouter description produits
   FULLTEXT search sur name + description
   ```

3. Index FULLTEXT non créé
   ```
   Vérifier setup.sql exécuté
   ALTER TABLE products ADD FULLTEXT INDEX ...
   ```

---

#### 08. Base de données "Connexion refusée"

**Symptôme** : "SQLSTATE[HY000]: General error"

**Causes** :

1. MySQL non running
   ```
   Démarrer : net start MySQL
   OU utiliser WAMP/XAMPP
   ```

2. Credentials incorrectes
   ```
   Vérifier App/Config/env.php
   db_host : localhost
   db_user : root (ou autre)
   db_pass : password (ou '')
   db_name : novashop_db
   ```

3. Database n'existe pas
   ```
   Créer : mysql -u root CREATE DATABASE novashop_db
   ```

**Réinitialiser complètement** :
```bash
# 1. Supprimer DB
mysql -h localhost -u root -p0000 -e "DROP DATABASE novashop_db"

# 2. Créer DB
mysql -h localhost -u root -p0000 -e "CREATE DATABASE novashop_db"

# 3. Importer setup.sql
mysql -h localhost -u root -p0000 novashop_db < setup.sql

# 4. Tester
php scripts/test_registration.php
```

---

### Logs pour déboguer

**Fichiers logs** : `/logs/`

```
/logs/user_delete.log
- Erreurs suppression utilisateur
- Format : [date time] Error message

/logs/error.log
- Erreurs globales
- Capturées par try-catch
```

**Lire logs** :
```bash
tail -20 logs/error.log
# Affiche 20 dernières lignes
```

**Mode debug (développement)** :

Décommenter dans `App/Core/App.php` :
```php
// Affiche full stacktrace au lieu de "erreur interne"
ini_set('display_errors', 1);
error_reporting(E_ALL);
```

---

## Conclusion

Vous disposez maintenant de :
- ✅ Rapport complet projet
- ✅ Guide utilisateur détaillé
- ✅ Guide administrateur complet
- ✅ Cas d'usage courants avec scénarios
- ✅ Dépannage problèmes courants

**Pour le rendre à la fac** :
1. Imprimer RAPPORT_PROJET.md (ou PDF)
2. Joindre ce guide GUIDE_UTILISATION.md
3. Montrer site en fonctionnement
4. Expliquer architecture MVC

Bonne présentation ! 🎓
