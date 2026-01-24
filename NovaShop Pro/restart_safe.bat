@echo off
REM ==========================================
REM NovaShop Pro - Version SAFE (sans download automatique)
REM ==========================================

cls
chcp 65001 > nul
setlocal enabledelayedexpansion

REM Couleurs
set "SUCCESS=[OK]"
set "ERROR=[ERREUR]"
set "INFO=[INFO]"
set "WARN=[ATTENTION]"

cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║         🌟 NovaShop Pro - Configuration Simplifiée 🌟          ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

REM Vérifier administrateur
net session >nul 2>&1
if errorlevel 1 (
    echo %ERROR% Ce script doit être exécuté en tant qu'administrateur!
    echo.
    echo Clic droit sur restart.bat ^> Exécuter en tant qu'administrateur
    echo.
    pause
    endlocal
    exit /b 1
)

echo %SUCCESS% Vous avez les droits administrateur
echo.

REM Vérifier PHP
echo %INFO% Vérification de PHP...
if exist "C:\php-8.2\php.exe" (
    echo %SUCCESS% PHP 8.2 trouvé
    set "FOUND_PHP=1"
) else (
    echo %WARN% PHP 8.2 non trouvé
    echo        Installez PHP 8.2 à C:\php-8.2
    echo        ou téléchargez depuis: https://windows.php.net/download/
    set "FOUND_PHP=0"
)
echo.

REM Vérifier MySQL
echo %INFO% Vérification de MariaDB/MySQL...
if exist "C:\Program Files\MariaDB\bin\mysql.exe" (
    echo %SUCCESS% MariaDB trouvé
    set "FOUND_MYSQL=1"
) else (
    echo %WARN% MariaDB non trouvé
    echo        Installez MariaDB à C:\Program Files\MariaDB
    echo        ou téléchargez depuis: https://mariadb.org/download/
    set "FOUND_MYSQL=0"
)
echo.

REM Si manquent outils, afficher instructions et quitter
if "!FOUND_PHP!"=="0" goto need_php
if "!FOUND_MYSQL!"=="0" goto need_mysql

REM Outils trouvés - continuer avec credentials
goto ask_credentials

:need_php
echo %ERROR% PHP est requis pour continuer
echo.
echo Installation de PHP:
echo  1. Visitez: https://windows.php.net/download/
echo  2. Téléchargez: php-8.2-nts-Win32-x64.zip (environ 80MB)
echo  3. Créez dossier: C:\php-8.2
echo  4. Extrayez le ZIP dedans
echo  5. Relancez ce script
echo.
pause
endlocal
exit /b 1

:need_mysql
echo %ERROR% MariaDB/MySQL est requis pour continuer
echo.
echo Installation de MariaDB:
echo  1. Visitez: https://mariadb.org/download/
echo  2. Téléchargez: MariaDB Server (version 10.5 ou +)
echo  3. Installez-le avec l'installateur MSI
echo  4. Assurez-vous que MariaDB s'installe à: C:\Program Files\MariaDB
echo  5. Relancez ce script
echo.
pause
endlocal
exit /b 1

:ask_credentials
REM ==========================================
REM Demander les identifiants
REM ==========================================

echo %INFO% Identifiants MySQL/MariaDB
echo.

set /p DB_USER="Nom d'utilisateur MySQL (défaut: root): "
if "!DB_USER!"=="" set "DB_USER=root"

set /p DB_PASS="Mot de passe MySQL (défaut: vide): "

echo.
echo %INFO% Configuration: USER=!DB_USER!
echo.

REM ==========================================
REM Menu Principal
REM ==========================================

:menu
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║                        📋 Menu Principal                       ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo   1️⃣  SETUP COMPLET
echo   2️⃣  RELANCER SERVEUR
echo   3️⃣  RÉINITIALISER BD
echo   4️⃣  TÉLÉCHARGER IMAGES
echo   5️⃣  NETTOYER CACHE
echo   6️⃣  RESET COMPLET
echo.

set /p CHOICE="Choisissez (1-6): "

if "!CHOICE!"=="1" goto setup_complet
if "!CHOICE!"=="2" goto restart_server
if "!CHOICE!"=="3" goto reset_db
if "!CHOICE!"=="4" goto download_images
if "!CHOICE!"=="5" goto clear_cache
if "!CHOICE!"=="6" goto full_reset

echo.
echo %ERROR% Choix invalide! (1-6 seulement)
pause
goto menu

REM ==========================================
REM OPTION 1: SETUP COMPLET
REM ==========================================
:setup_complet
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║              ⚙️  SETUP COMPLET (Clone Initial)                ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

echo %INFO% Étape 1/3: Initialisation de la base de données...
echo.

REM Utiliser PHP si trouvé
if "!FOUND_PHP!"=="1" (
    echo %INFO% Utilisation de PHP...
    set "DB_HOST=localhost"
    set "DB_USER=!DB_USER!"
    set "DB_PASS=!DB_PASS!"
    
    php "%~dp0start_novashop.php" 2>nul
    if errorlevel 1 (
        echo %WARN% PHP a échoué, essai avec MySQL CLI...
        call :init_db_mysql
    )
) else if "!FOUND_MYSQL!"=="1" (
    echo %INFO% Utilisation de MySQL CLI...
    call :init_db_mysql
) else (
    echo %ERROR% Ni PHP ni MySQL disponible!
    pause
    goto menu
)

echo.
echo %SUCCESS% Étape 1 complétée
echo.
pause
goto menu

REM ==========================================
REM OPTION 2: RELANCER SERVEUR
REM ==========================================
:restart_server
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║                   🔄 RELANCER SERVEUR                         ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

echo %INFO% Relance du serveur PHP...
cd /d "%~dp0Public"
php -S localhost:8000

goto menu

REM ==========================================
REM OPTION 3: RÉINITIALISER BD
REM ==========================================
:reset_db
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║              🔄 RÉINITIALISER BASE DE DONNÉES                  ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

echo %WARN% Cette opération va supprimer et recréer la BD...
echo.
pause

call :init_db_mysql

echo.
echo %SUCCESS% BD réinitialisée
echo.
pause
goto menu

REM ==========================================
REM OPTION 4: TÉLÉCHARGER IMAGES
REM ==========================================
:download_images
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║              📥 TÉLÉCHARGER IMAGES PRODUITS                    ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

echo %INFO% Téléchargement des images produits...
cd /d "%~dp0Public/Assets/Images/products"

if exist "%~dp0scripts\download_product_images.php" (
    php "%~dp0scripts\download_product_images.php"
) else (
    echo %ERROR% Script de téléchargement non trouvé
)

echo.
echo %SUCCESS% Images téléchargées
echo.
pause
goto menu

REM ==========================================
REM OPTION 5: NETTOYER CACHE
REM ==========================================
:clear_cache
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║              🧹 NETTOYER CACHE NAVIGATEUR                      ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

echo %INFO% Instructions pour nettoyer le cache:
echo.
echo FIREFOX:
echo  1. Ctrl+H pour ouvrir Historique
echo  2. Clic sur "Supprimer toutes les données privées"
echo  3. Sélectionner "Cache" uniquement
echo.
echo CHROME/EDGE:
echo  1. Ctrl+Maj+Suppr
echo  2. Sélectionner "Toutes les périodes"
echo  3. Cocher "Images et fichiers en cache"
echo  4. Cliquer "Supprimer les données"
echo.
echo INTERNET EXPLORER:
echo  1. Ctrl+Maj+Suppr
echo  2. Cliquer "Supprimer"
echo.
pause
goto menu

REM ==========================================
REM OPTION 6: RESET COMPLET
REM ==========================================
:full_reset
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║                  ⚠️  RESET COMPLET                            ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

echo %ERROR% ATTENTION: Ceci va SUPPRIMER TOUS les données!
echo.
echo Êtes-vous sûr? (O/N)
set /p CONFIRM="Confirmer: "

if /i "!CONFIRM!"=="O" (
    echo %INFO% Suppression de la base de données...
    
    if "!FOUND_MYSQL!"=="1" (
        mysql -u !DB_USER! -p!DB_PASS! -e "DROP DATABASE IF EXISTS novashop" 2>nul
        echo %SUCCESS% BD supprimée
    )
    
    echo.
    echo %SUCCESS% Reset complet effectué
) else (
    echo %WARN% Opération annulée
)

echo.
pause
goto menu

REM ==========================================
REM FONCTION: Initialiser BD avec MySQL
REM ==========================================
:init_db_mysql
setlocal enabledelayedexpansion

echo %INFO% Initialisation de la BD avec MySQL CLI...

REM Créer BD
mysql -u !DB_USER! -p!DB_PASS! -e "DROP DATABASE IF EXISTS novashop" 2>nul
mysql -u !DB_USER! -p!DB_PASS! -e "CREATE DATABASE novashop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci" 2>nul

if errorlevel 1 (
    echo %ERROR% Erreur lors de la création de la BD
    endlocal
    exit /b 1
)

REM Importer les tables
mysql -u !DB_USER! -p!DB_PASS! novashop < "%~dp0setup.sql" 2>nul
if errorlevel 1 (
    echo %ERROR% Erreur lors de l'import des tables
    endlocal
    exit /b 1
)

REM Importer les données
mysql -u !DB_USER! -p!DB_PASS! novashop < "%~dp0seed_premium.sql" 2>nul
if errorlevel 1 (
    echo %WARN% Données premium non importées, import standard...
    mysql -u !DB_USER! -p!DB_PASS! novashop < "%~dp0seed.sql" 2>nul
)

echo %SUCCESS% Base de données initialisée!
endlocal
exit /b 0

REM ==========================================
REM FIN
REM ==========================================
:end
echo.
echo À bientôt!
echo.
endlocal
exit /b 0
