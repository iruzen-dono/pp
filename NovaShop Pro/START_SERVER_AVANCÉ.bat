@echo off
REM ======================================================
REM NovaShop Pro - Démarrage serveur PHP (AVANCÉ)
REM ======================================================
REM Utiliser START_SERVER_SIMPLE.bat si problèmes

setlocal enabledelayedexpansion

echo.
echo ====================================================
echo  NovaShop Pro - Serveur de développement
echo ====================================================
echo.

REM Vérifier PHP disponible
where php >nul 2>nul
if errorlevel 1 (
    echo ERREUR: PHP n'est pas installé ou pas dans PATH
    echo.
    echo Solutions:
    echo 1. Installer PHP depuis https://www.php.net/downloads
    echo 2. Ajouter PHP au PATH système
    echo.
    pause
    exit /b 1
)

REM Afficher version PHP
echo Vérification PHP...
for /f "tokens=*" %%i in ('php --version') do (
    echo %%i
    goto :php_ok
)

:php_ok
echo.

REM Vérifier répertoire
if not exist "Public\index.php" (
    echo ERREUR: Veuillez placer ce fichier dans le dossier "NovaShop Pro"
    echo Chemin actuel: %CD%
    echo.
    pause
    exit /b 1
)

REM Afficher informations
echo Démarrage du serveur...
echo.
echo Adresse : http://localhost:8000
echo Arrêt   : Appuyez sur CTRL+C
echo.
echo ====================================================
echo.

REM Démarrer le serveur PHP
php -S localhost:8000 -t Public Public/router.php

REM Si le serveur s'arrête
echo.
echo Serveur arrêté.
pause
