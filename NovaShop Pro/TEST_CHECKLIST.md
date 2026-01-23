# 🧪 CHECKLIST DE TESTS COMPLETS - NovaShop Pro

**Date:** 23 Janvier 2026  
**Objectif:** Valider que tous les flux fonctionnent après les fixes  
**Serveur:** http://localhost:8000

---

## 🏠 TEST 1: PAGE D'ACCUEIL

### Étapes:
- [ ] Accédez à `http://localhost:8000`
- [ ] La page charge sans erreur
- [ ] Hero section visible avec boutons

### Vérifications:
- [ ] Carousel des produits vedettes visible
- [ ] Boutons "Voir détails" fonctionnent
- [ ] Features grid (4 cartes) affichées
- [ ] Grid produits (6 produits) affichées
- [ ] CTA section en bas visible

### Dark mode:
- [ ] Cliquez sur 🌙 (coin inférieur gauche)
- [ ] Page passe en mode sombre
- [ ] Cliquez à nouveau pour passer en clair
- [ ] La sélection persiste au reload

### Wishlist:
- [ ] Cliquez sur 🤍 (coin supérieur droit d'une carte produit)
- [ ] Le cœur devient rouge ❤️
- [ ] Le cœur reste rouge au reload

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 🔐 TEST 2: INSCRIPTION

### Étapes:
- [ ] Allez à `http://localhost:8000/?url=auth/register`
- [ ] Page s'affiche correctement (style OK)
- [ ] Formulaire visible avec 3 champs

### Inscription réussie:
- [ ] Remplissez: Nom = "Test User", Email = "test@novashop.local", Password = "test123"
- [ ] Cliquez "S'inscrire"
- [ ] Redirige vers login
- [ ] Message de succès apparaît (optionnel)

### Validation:
- [ ] Vérifiez dans phpMyAdmin: nouvel utilisateur en BD
- [ ] Le mot de passe est hashé (commence par $2y$)
- [ ] Role = 'user' (par défaut)

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 🔑 TEST 3: CONNEXION

### Étapes:
- [ ] Allez à `http://localhost:8000/?url=auth/login`
- [ ] Page s'affiche avec formulaire

### Connexion correcte:
- [ ] Email = "test@novashop.local", Password = "test123"
- [ ] Cliquez "Se connecter"
- [ ] Redirige vers accueil
- [ ] Vérifiez header: 🌙 et ↑ boutons visibles

### Vérification Session:
- [ ] Ouvrez console: `console.log(sessionStorage)`
- [ ] OU Check: Navigateur Dev Tools > Application > Cookies
- [ ] Session utilisateur créée

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 📦 TEST 4: CATALOGUE PRODUITS

### Étapes:
- [ ] Allez à `http://localhost:8000/?url=products` 
- [ ] Page affiche tous les produits
- [ ] Breadcrumbs: Accueil / Produits

### Recherche:
- [ ] Tapez "Laptop" dans la barre de recherche
- [ ] Cliquez "Chercher"
- [ ] Seuls les produits correspondants affichés
- [ ] Autres produits cachés

### Wishlist:
- [ ] Cliquez plusieurs 🤍 sur différents produits
- [ ] Cœurs deviennent ❤️
- [ ] Les sélections persistent

### Ratings:
- [ ] Voyez 5 ⭐ sur chaque produit
- [ ] Survol d'une étoile = elle se colore
- [ ] 4/5 affichées par défaut

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 🔍 TEST 5: DÉTAIL PRODUIT

### Étapes:
- [ ] Cliquez sur "Voir détails" d'un produit
- [ ] URL change: `?url=product/1` ou `/product/1`
- [ ] Page détail charge

### Affichage:
- [ ] Breadcrumbs corrects: Accueil / Produits / Nom Produit
- [ ] Image produit affichée (ou 📦)
- [ ] Titre, prix, description visibles
- [ ] Stock disponible affiché
- [ ] Ratings: 4 étoiles actives/rouges

### Tabs:
- [ ] Tab "Description" par défaut
- [ ] Cliquez "Avis (87)" → affiche 2 avis clients
- [ ] Cliquez "Livraison" → affiche options livraison
- [ ] Tab borders changent correctement

### Parallax:
- [ ] Scrollez la page
- [ ] Image produit se déplace légèrement
- [ ] Effet de parallax visible

### Actions:
- [ ] Changez quantité à 3
- [ ] Cliquez "Ajouter au panier 🛒"
- [ ] Page doit recharger (redirige vers panier)

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 🛒 TEST 6: PANIER

### Étapes:
- [ ] Vous êtes redirigé après ajout produit
- [ ] URL: `?url=cart`
- [ ] Panier affiche le produit ajouté

### Vérification:
- [ ] Produit avec quantité 3 visible
- [ ] Calcul du total correct: quantité × prix
- [ ] Boutons "Supprimer" fonctionnent

### Ajout multiple:
- [ ] Allez à `/products`, ajoutez autre produit
- [ ] Revenez au panier
- [ ] 2 produits différents affichés

### Suppression:
- [ ] Cliquez "Supprimer" sur un article
- [ ] Article disparaît
- [ ] Total recalculé
- [ ] Page redirige vers panier

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 🛍️ TEST 7: CRÉATION COMMANDE

### Étapes:
- [ ] Depuis le panier avec 2-3 articles
- [ ] Cliquez "Passer la commande"
- [ ] Page change (optionnel: formulaire adresse)
- [ ] Commande créée

### Vérification:
- [ ] Redirigé vers `/orders`
- [ ] Panier vidé
- [ ] Nouvelle commande visible dans la liste
- [ ] Statut = "⏳ En attente"

### BD Check:
- [ ] Vérifiez phpMyAdmin: `orders` table
- [ ] Nouvelle commande présente
- [ ] user_id correct
- [ ] total calculé correctement
- [ ] Vérifiez `order_items`: articles de la commande

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 📋 TEST 8: COMMANDES

### Étapes:
- [ ] Allez à `?url=orders`
- [ ] Votre commande affichée dans la table

### Affichage:
- [ ] ID commande: #1 (ou suivant)
- [ ] Total: X.XX€
- [ ] Statut: ⏳ En attente
- [ ] Date: aujourd'hui
- [ ] Bouton "Voir détails"

### Détail commande:
- [ ] Cliquez "Voir détails"
- [ ] URL: `?url=orders/show?id=1`
- [ ] Commande détail affichée
- [ ] Items avec produits, quantités, prix
- [ ] Calcul du total correct

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 🔒 TEST 9: SÉCURITÉ PANIER

### Vérification critique:
- [ ] Déconnectez-vous (Déconnexion en haut)
- [ ] URL: `?url=auth/logout`
- [ ] Redirige à l'accueil

### Test panier sans auth:
- [ ] Essayez d'accéder à `?url=cart/add` directement
- [ ] Message d'erreur? OU redirige vers login?
- [ ] Ne devrait PAS fonctionner sans être connecté

### Test remove sans auth:
- [ ] Essayez `?url=cart/remove?id=1`
- [ ] Doit bloquer OU rediriger

**Résultat attendu:** AuthMiddleware bloque l'accès ✅

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 👤 TEST 10: ADMIN PANEL (Optionnel)

### Accès:
- [ ] Déconnectez-vous
- [ ] Connectez-vous avec admin@novashop.local / admin123
- [ ] Allez à `?url=admin/dashboard`

### Dashboard:
- [ ] Page charge
- [ ] Sidebar visible à gauche
- [ ] Stats cards affichées:
  - [ ] 👥 Utilisateurs (nombre)
  - [ ] 📦 Produits (nombre)
  - [ ] 🛒 Commandes (nombre)
- [ ] Links vers Users, Products, Orders

### Admin vs User:
- [ ] Connectez-vous avec user@novashop.local / user123
- [ ] Essayez `?url=admin/dashboard`
- [ ] Doit bloquer (middleware admin check)
- [ ] Message d'erreur ou redirige

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 💾 TEST 11: PERSISTANCE DATA

### Panier:
- [ ] Ajoutez produits au panier
- [ ] F5 (Reload page)
- [ ] **Produits toujours là?** ✅ (SESSION persiste)
- [ ] Fermez navigateur
- [ ] Rouvrez: **Produits parties?** ✅ (Normal, session fermée)

### Dark Mode:
- [ ] Activez dark mode
- [ ] F5
- [ ] **Mode sombre persiste?** ✅ (localStorage)
- [ ] Fermez navigateur
- [ ] Rouvrez: **Mode sombre revient?** ✅

### Wishlist:
- [ ] Cochez des ❤️ produits
- [ ] F5
- [ ] **Cœurs rouges reviennent?** ✅ (localStorage)

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 🎨 TEST 12: ANIMATIONS & DESIGN

### Scroll Animations:
- [ ] Sur accueil, scrollez lentement
- [ ] Produits slide in avec fade up
- [ ] Features cards s'animent
- [ ] Staggered delays visibles

### Carousel:
- [ ] Sur accueil, carousel visible
- [ ] Cliquez ❮ / ❯ (flèches)
- [ ] Slides changent
- [ ] Dots navigation met à jour
- [ ] Auto-play (5 sec)?

### Hover effects:
- [ ] Cartes produits: zoom + shadow
- [ ] Boutons: couleur change
- [ ] 🤍 wishlist: pulse animation

### Parallax:
- [ ] Page produit: scrollez
- [ ] Image bouge différemment que reste de page

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## ⚠️ TEST 13: GESTION D'ERREURS

### Produit inexistant:
- [ ] Allez à `?url=product/99999`
- [ ] Message: "Produit non trouvé" ?
- [ ] Page ne crash pas

### Quantité invalide:
- [ ] Page détail produit
- [ ] Mettez 0 ou nombre négatif
- [ ] Submit
- [ ] Doit bloquer OU ignorer

### Panier vide:
- [ ] Videz panier (supprimer tous articles)
- [ ] Cliquez "Passer la commande"
- [ ] Message: "Panier vide"?
- [ ] Doit diriger vers produits

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 🖥️ TEST 14: RESPONSIVE DESIGN

### Mobile (375px):
- [ ] Ouvrez dev tools (F12)
- [ ] Responsive mode, mobile iPhone
- [ ] [ ] Navigation responsive
- [ ] [ ] Panier affiche bien
- [ ] [ ] Produits en 1-2 colonnes
- [ ] [ ] Boutons cliquables

### Tablet (768px):
- [ ] Mode tablette
- [ ] [ ] Layout adapté
- [ ] [ ] Carousel visible
- [ ] [ ] Forms responsive

### Desktop (1440px):
- [ ] Mode desktop
- [ ] [ ] Tous les éléments visibles
- [ ] [ ] Spacing correct
- [ ] [ ] Aucun overflow

**État:** [ ] ✅ PASS  [ ] ❌ FAIL

---

## 📊 RÉSUMÉ

### Résultats:
- Tests réussis: ____ / 14
- Tests échoués: ____ / 14
- Taux de succès: ____%

### Bugs trouvés:
1. ___________
2. ___________
3. ___________

### Notes:
(Ajouter observations ici)

---

## 🎉 CONCLUSION

- [ ] Tous les tests PASS → **Production Ready** 🟢
- [ ] Quelques tests FAIL → **À corriger avant prod** 🟡
- [ ] Beaucoup de tests FAIL → **Pas prêt** 🔴

