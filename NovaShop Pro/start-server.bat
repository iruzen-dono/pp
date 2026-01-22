@echo off
echo 🚀 Démarrage du serveur NovaShop Pro...
echo.
echo 📍 URL: http://localhost:8000
echo 📍 Accueil: http://localhost:8000/
echo 📍 Produits: http://localhost:8000/products
echo 📍 Connexion: http://localhost:8000/login
echo 📍 Diagnostic: http://localhost:8000/public/diagnostic.php
echo.
echo Appuyez sur CTRL+C pour arrêter le serveur
echo.

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
