# 🚀 Démarrage du serveur NovaShop Pro

## Fichiers availables

### 1. START_SERVER.bat ⭐ RECOMMANDÉ
```
Double-clic pour lancer
- Vérification répertoire
- Message clair
- Simple et efficace
```

### 2. START_SERVER_AVANCÉ.bat 
```
Version avec vérifications PHP
- Vérifie si PHP est installé
- Affiche version PHP
- Messages détaillées
- À utiliser si problèmes
```

### 3. START_SERVER_SIMPLE.bat
```
Version ultra-simple
- Juste lance le serveur
- Minimum de vérifications
- Secours si autres ne marchent pas
```

---

## Mode d'emploi

### Étape 1 : Vérifier que vous êtes au bon endroit

Le fichier `.bat` doit être dans le dossier `NovaShop Pro` :
```
c:\Users\Jules\OneDrive\Desktop\pp\NovaShop Pro\
├─ START_SERVER.bat  ← Ici
├─ Public/
├─ App/
└─ ...
```

### Étape 2 : Double-cliquer le fichier

```
Double-clic sur START_SERVER.bat
↓
Console s'ouvre
↓
Messages : "Démarrage du serveur..."
↓
"Adresse : http://localhost:8000"
↓
Server running ✓
```

### Étape 3 : Ouvrir navigateur

```
http://localhost:8000
↓
Site NovaShop Pro affiche
```

### Étape 4 : Arrêter le serveur

```
Appuyer : CTRL + C
Taper : Y puis Entrée
Serveur s'arrête
```

---

## Si erreurs

### Erreur: "PHP n'est pas reconnu"
```
Solution 1: Utiliser START_SERVER_SIMPLE.bat

Solution 2: Ajouter PHP au PATH
- Chercher : "Variables d'environnement"
- Ajouter dossier PHP à PATH
- Redémarrer terminal
```

### Erreur: "Public\index.php introuvable"
```
Vérifier chemin :
- Placer START_SERVER.bat dans NovaShop Pro/
- NON pas à la racine pp/
- Bon chemin :
  pp/NovaShop Pro/START_SERVER.bat ✓
```

### Console disparaît immédiatement
```
Utiliser START_SERVER.bat (affiche pause)
OU : Utiliser terminal manuel
  cd "c:\Users\Jules\OneDrive\Desktop\pp\NovaShop Pro"
  php -S localhost:8000 -t Public Public/router.php
```

---

## Utilisation manuelle (alternativement)

Si vous préférez lancer depuis PowerShell/CMD :

```powershell
# Naviguer au dossier
cd "c:\Users\Jules\OneDrive\Desktop\pp\NovaShop Pro"

# Lancer serveur
php -S localhost:8000 -t Public Public/router.php

# Ouvrir navigateur
start http://localhost:8000

# Pour arrêter : CTRL+C
```

---

## Astuces

### Raccourci bureau
```
1. Clic droit → "Envoyer vers" → "Bureau (créer raccourci)"
2. Double-clic depuis bureau pour lancer serveur
3. Pratique !
```

### Lancer + navigateur automatique
```
Créer fichier: LAUNCH_SITE.bat
Contenu:
@echo off
cd "c:\Users\Jules\OneDrive\Desktop\pp\NovaShop Pro"
start http://localhost:8000
php -S localhost:8000 -t Public Public/router.php
```

### Port différent (8000 occupé)
```
Modifier START_SERVER.bat ligne:
php -S localhost:8000 -t Public Public/router.php
            ↓
php -S localhost:8001 -t Public Public/router.php

Accéder : http://localhost:8001
```

---

## Problèmes ?

Si rien ne marche :

1. Vérifier PHP instalé :
   ```
   cmd → php --version
   ```

2. Vérifier port libre :
   ```
   netstat -ano | findstr :8000
   ```

3. Vérifier base de données MySQL running :
   ```
   Ouvrir XAMPP / WAMP
   OU : net start MySQL80
   ```

4. Vérifier chemin :
   ```
   START_SERVER.bat doit être dans NovaShop Pro/
   ```

---

Besoin d'aide ? Voir documentation complète :
- RAPPORT_PROJET.md
- GUIDE_UTILISATION.md
- DOCUMENT_TECHNIQUE.md
