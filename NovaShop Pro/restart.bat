@echo off
REM ==========================================
REM NovaShop Pro - Menu Principal
REM ==========================================

chcp 65001 > nul
setlocal enabledelayedexpansion

set "SUCCESS=[OK]"
set "ERROR=[ERREUR]"
set "INFO=[INFO]"

cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║         🌟 NovaShop Pro - Configuration 🌟                     ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

REM VERIFY PHP
echo %INFO% Recherche de PHP...
set "PHP_OK=0"

php --version >nul 2>&1
if !errorlevel! equ 0 (
    echo %SUCCESS% PHP trouvé dans le PATH
    set "PHP_OK=1"
    goto php_done
)

for %%P in (
    "C:\php-8.2\php.exe"
    "C:\php-8.1\php.exe"
    "C:\php\php.exe"
    "C:\xampp\php\php.exe"
    "C:\Program Files\php\php.exe"
) do (
    if exist %%P (
        echo %SUCCESS% PHP trouvé à : %%P
        set "PHP_OK=1"
        goto php_done
    )
)

REM Recherche Wamp (Gestion du wildcard *)
if exist "C:\wamp64\bin\php\" (
    for /d %%D in ("C:\wamp64\bin\php\php*") do (
        if exist "%%D\php.exe" (
            echo %SUCCESS% PHP trouvé dans Wamp : %%D\php.exe
            set "PHP_OK=1"
            goto php_done
        )
    )
)

:php_done
if "!PHP_OK!"=="0" echo %ERROR% PHP non trouvé.

REM VERIFY MYSQL
echo %INFO% Recherche de MariaDB/MySQL...
set "MYSQL_OK=0"

mysql --version >nul 2>&1
if !errorlevel! equ 0 (
    echo %SUCCESS% MySQL trouvé dans le PATH
    set "MYSQL_OK=1"
    goto mysql_done
)

for %%P in (
    "C:\Program Files\MariaDB\bin\mysql.exe"
    "C:\mysql\bin\mysql.exe"
    "C:\xampp\mysql\bin\mysql.exe"
) do (
    if exist %%P (
        echo %SUCCESS% MySQL trouvé à : %%P
        set "MYSQL_OK=1"
        goto mysql_done
    )
)

if exist "C:\wamp64\bin\mysql\" (
    for /d %%D in ("C:\wamp64\bin\mysql\mysql*") do (
        if exist "%%D\bin\mysql.exe" (
            echo %SUCCESS% MySQL trouvé dans Wamp : %%D\bin\mysql.exe
            set "MYSQL_OK=1"
            goto mysql_done
        )
    )
)

:mysql_done
if "!MYSQL_OK!"=="0" echo %ERROR% MySQL non trouvé.

echo.

if "!PHP_OK!"=="0" goto missing_tools
if "!MYSQL_OK!"=="0" goto missing_tools

echo %SUCCESS% Tous les outils sont détectés !
goto ask_credentials

:missing_tools
echo %ERROR% Installation requise !
echo.
if "!PHP_OK!"=="0" (
    echo INSTALLER PHP 8.2+:
    echo  1. Télécharger: https://windows.php.net/download/
    echo  2. Extraire dans: C:\php
)
if "!MYSQL_OK!"=="0" (
    echo INSTALLER MARIADB:
    echo  1. Télécharger: https://mariadb.org/download/
)
echo.
pause
exit /b 1

:ask_credentials
echo.
set /p DB_USER="Utilisateur MySQL (defaut: root) : "
if "!DB_USER!"=="" set "DB_USER=root"
set /p DB_PASS="Mot de passe MySQL (laisser vide si aucun) : "

REM Construire la commande de mot de passe
if "!DB_PASS!"=="" (
    set "PASS_CMD="
) else (
    set "PASS_CMD=-p!DB_PASS!"
)

REM Vérification des identifiants
echo.
echo %INFO% Vérification des identifiants MySQL...
echo SELECT 1; | mysql -u !DB_USER! !PASS_CMD! >nul 2>&1

if !errorlevel! equ 0 (
    echo %SUCCESS% Connexion réussie avec l'utilisateur !DB_USER!
    echo.
    goto menu
)

echo %ERROR% Identifiants incorrects ^!
echo.
echo Assurez-vous que:
echo  - MySQL/MariaDB est démarré
echo  - Le nom d'utilisateur est correct (actuellement: !DB_USER!)
echo  - Le mot de passe est correct
echo.
pause
goto ask_credentials

:menu
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║         NovaShop Pro - Menu Principal                          ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo  1 = Setup Base de Données
echo  2 = Lancer le Serveur (localhost:8000)
echo  3 = Réinitialiser DB (garder données)
echo  4 = Synchroniser Images Produits
echo  5 = Vider Cache Browser
echo  6 = Vérifier Configuration
echo  7 = Full Reset (supprimer tout)
echo  8 = Quitter
echo.
set /p CHOICE="Votre choix (1-8): "

if "!CHOICE!"=="1" goto setup
if "!CHOICE!"=="2" goto restart
if "!CHOICE!"=="3" goto reset
if "!CHOICE!"=="4" goto images
if "!CHOICE!"=="5" goto cache
if "!CHOICE!"=="6" goto verify
if "!CHOICE!"=="7" goto fullreset
if "!CHOICE!"=="8" exit /b 0
goto menu

:setup
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║  ⚠️  SETUP COMPLET - NETTOYAGE TOTAL EN COURS                  ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo %WARNING% ATTENTION: Toutes les données existantes seront supprimées!
echo.
pause
echo.

echo %INFO% Vérification des données existantes...
mysql -u !DB_USER! !PASS_CMD! -e "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME='novashop';" > nul 2>&1
if !errorlevel! equ 0 (
    echo %WARNING% Base de données 'novashop' existante détectée - Suppression...
) else (
    echo %INFO% Aucune base de données existante - Création...
)
echo.

echo %INFO% Suppression des anciennes images...
del /Q "%~dp0Public\Assets\Images\products\*.png" > nul 2>&1
del /Q "%~dp0Public\Assets\Images\products\*.jpg" > nul 2>&1
echo %SUCCESS% Images supprimées.

echo %INFO% Création de la base de données novashop...
mysql -u !DB_USER! !PASS_CMD! -e "DROP DATABASE IF EXISTS novashop; CREATE DATABASE novashop CHARACTER SET utf8mb4;"
if errorlevel 1 (
    echo %ERROR% Échec de création de la base de données.
    pause
    goto menu
)
echo %SUCCESS% Base de données créée (vide).

echo %INFO% Import du schéma initial...
mysql -u !DB_USER! !PASS_CMD! novashop < "%~dp0setup.sql"
if errorlevel 1 (
    echo %ERROR% Échec de l'import du schéma.
    pause
    goto menu
)
echo %SUCCESS% Schéma importé (tables + utilisateurs).

echo %INFO% Import des données premium (35 produits)...
mysql -u !DB_USER! !PASS_CMD! novashop < "%~dp0scripts\seed_premium.sql"
if errorlevel 1 (
    echo %ERROR% Échec de l'import des données.
    pause
    goto menu
)
echo %SUCCESS% Données premium importées (35 produits).

echo.
echo %INFO% Téléchargement des vraies images produits depuis Unsplash...
cd /d "%~dp0"
php scripts\download_real_images.php
if errorlevel 1 (
    echo %WARNING% Certaines images n'ont pas pu être téléchargées (non critique).
) else (
    echo %SUCCESS% Images produits téléchargées.
)

echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║  ✅ SETUP COMPLET TERMINÉ AVEC SUCCÈS                          ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo %INFO% Base de données:
echo       • 2 utilisateurs (admin + user)
echo       • 5 catégories (Électronique, Mode, Livres, Maison, Sports)
echo       • 35 produits premium
echo.
echo %INFO% Images produits: 35 fichiers PNG (Unsplash)
echo %INFO% Accédez au site: http://localhost:8000
echo %INFO% Lancez ensuite l'option 2 (Serveur).
echo.
pause
goto menu

:restart
cls
echo %INFO% Démarrage du serveur PHP...
echo.
echo 🌐 Serveur accessible sur: http://localhost:8000
echo 🛑 Appuyez sur CTRL+C pour arrêter le serveur
echo.
if exist "%~dp0Public" (
    cd /d "%~dp0Public"
    php -S localhost:8000 router.php
) else (
    echo %ERROR% Dossier /Public introuvable.
    pause
)
goto menu

:reset
cls
echo %INFO% Réinitialisation de la base de données...
echo.
mysql -u !DB_USER! !PASS_CMD! novashop < "%~dp0setup.sql"
if errorlevel 1 (
    echo %ERROR% Échec de la réinitialisation du schéma.
    pause
    goto menu
)
echo %SUCCESS% Schéma réinitialisé.

echo %INFO% Import des données premium (35 produits)...
mysql -u !DB_USER! !PASS_CMD! novashop < "%~dp0scripts\seed_premium.sql"
if errorlevel 1 (
    echo %ERROR% Échec de l'import des données.
    pause
    goto menu
)
echo %SUCCESS% Données premium importées.

echo.
echo %SUCCESS% Réinitialisation terminée !
echo.
pause
goto menu

:images
cls
echo Téléchargement et création des images produits...
echo %INFO% Étape 1: Tentative de synchronisation...
if exist "%~dp0scripts\sync_product_images.php" (
    php "%~dp0scripts\sync_product_images.php"
    echo %SUCCESS% Images synchronisées!
) else (
    echo %INFO% Script de synchronisation non disponible
)

echo.
echo %INFO% Étape 2: Téléchargement depuis Unsplash...
if exist "%~dp0scripts\download_product_images.php" (
    php "%~dp0scripts\download_product_images.php"
    echo %SUCCESS% Images téléchargées!
) else (
    echo %INFO% Script de téléchargement non disponible
)

echo.
echo %INFO% Étape 3: Création des images PNG de fallback...
if exist "%~dp0scripts\generate_images.php" (
    php "%~dp0scripts\generate_images.php"
    echo %SUCCESS% Images PNG créées!
) else (
    echo %ERROR% Script de génération introuvable.
)

echo.
pause
goto menu

:cache
cls
echo Pour vider le cache du navigateur :
echo FIREFOX : Ctrl+H ^> Supprimer
echo CHROME/EDGE : Ctrl+Maj+Suppr
pause
goto menu

:verify
cls
echo %INFO% Vérification de la configuration...
echo.
echo === Fichiers et Dossiers ===
if exist "%~dp0Public" (
    echo %SUCCESS% Public/
) else (
    echo %ERROR% Public/ manquant
)
if exist "%~dp0App" (
    echo %SUCCESS% App/
) else (
    echo %ERROR% App/ manquant
)
if exist "%~dp0Public\Assets\Css\Style.css" (
    echo %SUCCESS% Assets CSS
) else (
    echo %ERROR% Assets CSS manquant
)
if exist "%~dp0Public\Assets\Js\main.js" (
    echo %SUCCESS% Assets JS
) else (
    echo %ERROR% Assets JS manquant
)
echo.
echo === Base de Données ===
set "DB_TABLES="
set "PRODUCT_COUNT="
for /f "tokens=1" %%A in ('mysql -u !DB_USER! !PASS_CMD! -se "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = 'novashop';" 2^>nul') do (
    set "DB_TABLES=%%A"
)
if "!DB_TABLES!"=="" (
    echo %ERROR% Base de données novashop inaccessible
) else (
    echo %SUCCESS% Tables en base: !DB_TABLES!
)
for /f "tokens=1" %%A in ('mysql -u !DB_USER! !PASS_CMD! -se "SELECT COUNT(*) FROM novashop.products;" 2^>nul') do (
    set "PRODUCT_COUNT=%%A"
)
if "!PRODUCT_COUNT!"=="" (
    echo %ERROR% Impossible de récupérer le nombre de produits
) else (
    echo %SUCCESS% Produits: !PRODUCT_COUNT!
)
echo.
pause
goto menu

:fullreset
cls
echo %ERROR% [ATTENTION] CETTE ACTION EST IRRÉVERSIBLE
echo.
echo Cela supprimera:
echo  - La base de données novashop entière
echo  - Tous les produits et commandes
echo  - Tous les utilisateurs
echo.
set /p CONFIRM="Êtes-vous SÛR ? (taper 'OUI' pour confirmer) : "
if /i "!CONFIRM!"=="OUI" (
    echo %INFO% Suppression en cours...
    mysql -u !DB_USER! !PASS_CMD! -e "DROP DATABASE IF EXISTS novashop"
    if errorlevel 1 (
        echo %ERROR% Erreur lors de la suppression
    ) else (
        echo %SUCCESS% Base de données supprimée.
        echo %INFO% Exécutez l'option 1 (Setup) pour recréer la base.
    )
) else (
    echo %INFO% Suppression annulée.
)
echo.
pause
goto menu