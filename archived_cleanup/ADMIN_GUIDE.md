# 📚 Guide d'Administration NovaShop Pro

## Table des matières
1. [Gestion des Produits](#gestion-des-produits)
2. [Gestion des Catégories](#gestion-des-catégories)
3. [Import en Masse](#import-en-masse)
4. [FAQ](#faq)

---

## 🛍️ Gestion des Produits

### Ajouter un produit rapidement

#### Méthode 1: Via l'interface web

1. Allez sur: `http://localhost/scripts/import_products.php`
2. Remplissez le formulaire "Ajouter un produit"
3. Cliquez sur "Ajouter le produit"

**Champs requis:**
- **Nom du produit** (texte): Nom unique du produit
- **Prix** (nombre): Prix en euros (ex: 29.99)

**Champs optionnels:**
- **Description**: Détails du produit (peut contenir HTML)
- **Catégorie**: Sélectionnez une catégorie existante
- **Stock**: Quantité disponible (défaut: 0)
- **URL de l'image**: Lien direct vers l'image

### Ajouter plusieurs produits

#### Méthode 1: Import CSV (Recommandé)

**Étape 1: Préparez votre fichier CSV**

Créez un fichier `produits.csv` avec ce format:

```csv
name,description,price,category,stock,image_url
Casque Bluetooth,Casque sans fil haute qualité,149.99,Électronique,15,https://exemple.com/casque.jpg
Montre Connectée,Suivi de la santé,299.99,Électronique,8,https://exemple.com/montre.jpg
Housse Protection,Housse pour téléphone,24.99,Accessoires,45,https://exemple.com/housse.jpg
```

**Important:**
- La première ligne doit contenir les en-têtes (noms des colonnes)
- Les caractères accentués doivent être en UTF-8
- Les prix utilisent le point (.) comme séparateur décimal
- L'URL de l'image peut être vide

**Étape 2: Téléchargez le fichier**

1. Allez sur: `http://localhost/scripts/import_products.php`
2. Section "Import CSV"
3. Cliquez sur la zone ou glissez-y votre fichier `produits.csv`
4. Cliquez sur "Importer le CSV"

#### Méthode 2: Import JSON

**Format du fichier:**

```json
[
  {
    "name": "Produit 1",
    "description": "Description du produit",
    "price": 29.99,
    "category": "Électronique",
    "stock": 10,
    "image_url": "https://exemple.com/produit1.jpg"
  },
  {
    "name": "Produit 2",
    "description": "Autre produit",
    "price": 49.99,
    "category": "Accessoires",
    "stock": 25,
    "image_url": "https://exemple.com/produit2.jpg"
  }
]
```

**Utilisation:**

1. Créez un fichier `products.json`
2. Allez sur: `http://localhost/scripts/import_products.php`
3. Section "Import JSON"
4. Glissez-y le fichier
5. Cliquez sur "Importer le JSON"

---

## 📂 Gestion des Catégories

### Ajouter une catégorie

Les catégories se créent **automatiquement** lors de l'import:

- Si vous spécifiez une catégorie n'existant pas lors de l'import, elle sera créée automatiquement
- Exemple: Si vous importez un produit avec `category: "Jeux Vidéo"`, la catégorie sera créée

### Lister les catégories existantes

L'interface d'import affiche toutes les catégories actuelles:

```
- Générale
- Électronique
- Accessoires
- Informatique
- Maison
- Etc...
```

### Créer manuellement une catégorie (via base de données)

Vous pouvez également créer une catégorie directement en base de données:

```sql
INSERT INTO categories (name, description) VALUES ('Nouvelle Catégorie', 'Description');
```

---

## 📥 Import en Masse

### Fichier CSV d'exemple

Un fichier `products.csv` est fourni avec 12 produits d'exemple:

**Chemin:** `/scripts/products.csv`

**Produits inclus:**
- Casque Bluetooth Premium
- Montre Connectée Pro
- Housse Protectrice
- Câble USB-C
- Batterie Externe 20000mAh
- Et 7 autres...

### Importer l'exemple

1. Allez sur: `http://localhost/scripts/import_products.php`
2. Cliquez sur "Importer le CSV"
3. 12 produits seront ajoutés

### Astuces pour un import réussi

✅ **À faire:**
- Utiliser UTF-8 comme encodage (Excel: Enregistrer sous > CSV UTF-8)
- Vérifier que les prix ont un format valide (ex: 29.99)
- Les catégories non existantes seront créées automatiquement
- Les images peuvent être des URLs complètes ou vides

❌ **À éviter:**
- Utiliser des virgules dans les descriptions (si possible)
- Les espaces superflus au début/fin des valeurs
- Les caractères spéciaux non UTF-8

---

## 🔍 Vérifier les produits importés

### Via l'interface web

1. Allez sur: `http://localhost/products`
2. Vous verrez tous les produits listés

### Via la base de données

```sql
-- Voir tous les produits
SELECT id, name, price, category_id, stock FROM products;

-- Voir les produits d'une catégorie
SELECT * FROM products WHERE category_id = 1;

-- Voir les produits en stock
SELECT * FROM products WHERE stock > 0 ORDER BY price DESC;

-- Compter les produits par catégorie
SELECT c.name, COUNT(p.id) as count 
FROM categories c 
LEFT JOIN products p ON c.id = p.category_id 
GROUP BY c.id;
```

---

## ⚙️ Configuration des fichiers

### Fichiers utilisés par l'import

```
/scripts/
├── import_products.php      # Interface d'administration
├── products.csv              # Exemple de fichier CSV
└── products.json             # Exemple de fichier JSON (si créé)
```

### Modifier l'emplacement des fichiers

Si vous mettez vos fichiers dans un autre dossier, modifiez les chemins dans `import_products.php`:

```php
define('CSV_FILE', __DIR__ . '/mon_dossier/produits.csv');
define('JSON_FILE', __DIR__ . '/mon_dossier/produits.json');
```

---

## 🐛 Dépannage

### "Fichier non trouvé"

**Problème:** Le fichier CSV/JSON n'est pas à l'endroit attendu

**Solution:**
1. Vérifiez que le fichier est dans `/scripts/`
2. Vérifiez le nom exact: `products.csv` (respect de la casse)
3. Vérifiez que le fichier n'est pas ouvert dans Excel

### "Format JSON invalide"

**Problème:** Le fichier JSON n'est pas valide

**Solution:**
1. Utilisez un validateur JSON en ligne
2. Vérifiez que chaque ligne est une chaîne valide
3. Utilisez une application JSON validator

### "Erreur de connexion à la base de données"

**Problème:** La base de données n'est pas accessible

**Solution:**
1. Vérifiez que MySQL est démarré
2. Vérifiez les identifiants dans `/App/Config/env.php`
3. Vérifiez que la base `novashop` existe

### Certains produits n'ont pas été importés

**Vérification:**
1. Regardez les messages d'erreur détaillés
2. Vérifiez les données des lignes avec erreur
3. Réessayez après correction

---

## 📊 Exemplesde données

### Données minimales pour un produit

```csv
name,description,price,category,stock,image_url
Produit,Une description,29.99,Générale,0,
```

### Données complètes

```csv
name,description,price,category,stock,image_url
Casque Premium,"Casque haute qualité avec réduction de bruit. Autonomie 30h. Connectivité Bluetooth 5.0",149.99,Électronique,15,https://example.com/casque.jpg
```

### Format JSON minimaliste

```json
[
  {
    "name": "Produit",
    "price": 29.99
  }
]
```

---

## 🔐 Sécurité

### Points importants

- L'interface d'import est accessible à `http://localhost/scripts/import_products.php`
- **À protéger:** En production, limitez l'accès via authentification admin
- Les données sont validées avant insertion
- Les caractères spéciaux sont échappés

### Protéger l'accès (Recommandé)

Modifiez le début de `import_products.php`:

```php
// Ajouter après la ligne 23
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    http_response_code(403);
    die('Accès refusé. Vous devez être administrateur.');
}
```

---

## 📚 Ressources additionnelles

- **Base de données:** `/setup.sql` - Script d'initialisation
- **Modèles:** `/App/Models/Product.php` - Classe Product
- **Configuration:** `/App/Config/Database.php` - Paramètres BD

---

## 💡 Conseils

1. **Pour commencer rapidement:** Importez le CSV d'exemple fourni
2. **Images:** Utilisez des URLs directes (pas d'upload de fichiers pour l'instant)
3. **Descriptions:** Vous pouvez utiliser du HTML basique
4. **Prix:** Utilisez toujours le format `29.99` (point décimal)
5. **Stock:** Laissez vide ou mettez 0 si non disponible

---

## Support

Si vous rencontrez des problèmes:

1. Vérifiez que le serveur PHP/MySQL est actif
2. Consultez les logs d'erreur du serveur
3. Essayez d'ajouter un produit manuellement d'abord
4. Vérifiez le format du fichier d'import

---

**Dernière mise à jour:** 2026  
**Version:** 1.0
