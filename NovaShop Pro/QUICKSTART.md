# 🎯 Démarrage Rapide - NovaShop Pro

## ⚡ 3 étapes pour démarrer

### 1. Installation des dépendances (si première fois)
```
Double-cliquez sur: setup_auto.bat
```
Cela détecte et installe automatiquement PHP + MariaDB.

### 2. Lancer l'application
```
Double-cliquez sur: restart.bat
```

### 3. Choisir l'option
```
Tapez: 1
```
Puis appuyez sur Entrée pour "SETUP COMPLET"

---

## 🌐 Accès à l'application

Une fois le serveur lancé:
```
http://localhost:8000
```

### Connexion Admin
```
Email: admin@novashop.local
Mot de passe: admin123
```

---

## 📋 Fichiers à connaître

| Fichier | Fonction |
|---------|----------|
| `setup_auto.bat` | Installation automatique (PHP + MariaDB) |
| `restart.bat` | Menu principal (6 options) |
| `SETUP_GUIDE.md` | Guide détaillé complet |
| `README_FINAL.md` | Documentation complète |

---

## 🆘 Ça ne marche pas?

### "PHP is not recognized"
→ Exécutez `setup_auto.bat`

### "MySQL not found"
→ Exécutez `setup_auto.bat`

### "Connection refused"
→ Vérifiez que MariaDB est en cours d'exécution:
- Appuyez sur Windows + R
- Tapez: `services.msc`
- Cherchez "MariaDB"
- Vérifiez qu'il est "En cours d'exécution"

---

**C'est tout! 🚀**

Pour plus d'infos, lisez `SETUP_GUIDE.md`
