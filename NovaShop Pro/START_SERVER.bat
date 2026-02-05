@echo off
REM ======================================================
REM NovaShop Pro - Démarrage serveur PHP
REM ======================================================

echo.
echo ====================================================
echo  NovaShop Pro - Serveur de développement
echo ====================================================
echo.

REM Vérifier si on est dans le bon répertoire
if not exist "Public\index.php" (
    echo ERREUR: Veuillez placer ce fichier dans le dossier "NovaShop Pro"
    echo Chemin actuel: %CD%
    pause
    exit /b 1
)

REM Afficher informations
echo Démarrage du serveur...
echo Adresse : http://localhost:8000
echo.
echo Appuyez sur CTRL+C pour arrêter le serveur
echo.

REM Démarrer le serveur PHP
php -S localhost:8000 -t Public Public/router.php

REM Si le serveur s'arrête, afficher message
echo.
echo Serveur arrêté.
pause
