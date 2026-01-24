@echo off
REM ==========================================
REM NovaShop Pro - Setup & Restart Complet
REM Pour cloner le depot: instructions completes
REM ==========================================

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
echo ║         🌟 NovaShop Pro - Configuration Complète 🌟            ║
echo ║                    Clonage ^& Initialisation                    ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

REM ==========================================
REM ETAPE 0a: Configuration MySQL/MariaDB
REM ==========================================

echo %INFO% Configuration MySQL/MariaDB requise
echo.
set /p DB_USER="Nom d'utilisateur MySQL (défaut: root): "
if "!DB_USER!"=="" set "DB_USER=root"

set /p DB_PASS="Mot de passe MySQL: "
if "!DB_PASS!"=="" set "DB_PASS=0000"

echo.
echo %INFO% Identifiants configurés: !DB_USER!
echo.

REM ==========================================
REM ETAPE 0: Detection PHP et MySQL/MariaDB
REM ==========================================

echo %INFO% Vérification des dépendances...
echo.

set MYSQL_PATH=
set FOUND_MYSQL=0
set FOUND_PHP=0

REM Vérifier PHP
where php.exe >nul 2>&1
if !errorlevel! equ 0 (
    echo %SUCCESS% PHP trouvé
    set FOUND_PHP=1
) else (
    echo %WARN% PHP non trouvé (MySQL CLI sera utilisé)
)

echo.

REM Vérifier si mysql est dans PATH
where mysql.exe >nul 2>&1
if !errorlevel! equ 0 (
    for /f "delims=" %%i in ('where mysql.exe') do set MYSQL_PATH=%%i
    set FOUND_MYSQL=1
    goto check_mysql_service
)

REM Chercher MariaDB
for /d %%G in ("C:\Program Files\MariaDB*") do (
    if exist "%%G\bin\mysql.exe" (
        set MYSQL_PATH=%%G\bin\mysql.exe
        set FOUND_MYSQL=1
        goto check_mysql_service
    )
)

REM Chercher MySQL
for /d %%G in ("C:\Program Files\MySQL*") do (
    if exist "%%G\bin\mysql.exe" (
        set MYSQL_PATH=%%G\bin\mysql.exe
        set FOUND_MYSQL=1
        goto check_mysql_service
    )
)

REM Chercher dans Program Files (x86)
for /d %%G in ("C:\Program Files (x86)\MariaDB*") do (
    if exist "%%G\bin\mysql.exe" (
        set MYSQL_PATH=%%G\bin\mysql.exe
        set FOUND_MYSQL=1
        goto check_mysql_service
    )
)

if !FOUND_MYSQL! equ 0 (
    echo.
    echo %ERROR% MySQL/MariaDB introuvable!
    echo.
    echo 📋 Solutions:
    echo    1. Télécharger MariaDB: https://mariadb.org/download
    echo    2. Ou installer MySQL: https://dev.mysql.com/downloads/mysql/
    echo    3. Installer avec chemin standard (C:\Program Files\MariaDB ou C:\Program Files\MySQL)
    echo    4. Ajouter bin au PATH Windows
    echo.
    pause
    goto end
)

:check_mysql_service
echo %SUCCESS% Trouvé: !MYSQL_PATH!
echo.

REM ==========================================
REM ETAPE 2: Menu principal
REM ==========================================

echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║                        📋 Menu Principal                       ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo   1️⃣  SETUP COMPLET (Installation initiale depuis clone)
echo   2️⃣  RELANCER SERVEUR (Sans reset des données)
echo   3️⃣  RÉINITIALISER BD (Récréer avec 35 produits premium)
echo   4️⃣  TÉLÉCHARGER IMAGES (Récupérer les photos produits)
echo   5️⃣  NETTOYER CACHE NAVIGATEUR (Instructions détaillées)
echo   6️⃣  RESET COMPLET (Effacer tout et recommencer)
echo.

set /p choice="Choisissez (1-6): "

if "%choice%"=="1" goto setup_complet
if "%choice%"=="2" goto restart_server
if "%choice%"=="3" goto reset_db
if "%choice%"=="4" goto download_images
if "%choice%"=="5" goto clear_cache
if "%choice%"=="6" goto full_reset

echo.
echo %ERROR% Choix invalide!
pause
cls
goto check_mysql_service

REM ==========================================
REM SETUP COMPLET - Pour clonage initial
REM ==========================================
:setup_complet
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║              ⚙️  SETUP COMPLET (Clone Initial)                ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo %INFO% Cette opération va:
echo      • Créer la base de données 'novashop'
echo      • Créer 5 tables (users, categories, products, orders, order_items)
echo      • Insérer 35 produits premium
echo      • Télécharger les images produits (35 photos)
echo.
pause

echo %INFO% Étape 1/3: Création de la base de données...

if !FOUND_PHP! equ 1 (
    set "DB_HOST=localhost"
    set "DB_USER=!DB_USER!"
    set "DB_PASS=!DB_PASS!"
    php "%~dp0start_novashop.php"
    if errorlevel 1 (
        echo %WARN% PHP a échoué, essai avec MySQL CLI...
        if !FOUND_MYSQL! equ 1 (
            call :init_db_mysql
            if errorlevel 1 (
                echo %ERROR% Erreur lors de l'initialisation BD!
                pause
                goto end
            )
        ) else (
            echo %ERROR% PHP et MySQL non disponibles!
            pause
            goto end
        )
    )
) else if !FOUND_MYSQL! equ 1 (
    call :init_db_mysql
    if errorlevel 1 (
        echo %ERROR% Erreur lors de l'initialisation BD!
        pause
        goto end
    )
) else (
    echo %ERROR% PHP et MySQL non trouvés!
    echo Exécutez setup_auto.bat pour installer les dépendances
    pause
    goto end
)

echo %SUCCESS% BD initialisée avec 35 produits premium!
echo.

echo %INFO% Étape 2/3: Téléchargement des images produits...
if !FOUND_PHP! equ 1 (
    php "%~dp0Public/Assets/Images/download_images.php" 2>nul
)
echo %SUCCESS% Téléchargement terminé!
echo.

if !FOUND_PHP! equ 1 (
    echo %INFO% Étape 3/3: Démarrage du serveur...
    echo.
    echo 🌐 Serveur disponible sur: http://localhost:8000
    echo.
    echo Identifiants admin:
    echo   Email: admin@novashop.local
    echo   Mot de passe: admin123
    echo.
    echo Appuyez sur Ctrl+C pour arrêter le serveur
    echo.
    pause

    cd /d "%~dp0Public"
    php -S localhost:8000 router.php
) else (
    echo %WARN% PHP non disponible. Impossible de démarrer le serveur.
    echo Installez PHP avec setup_auto.bat
    pause
)
goto end

REM ==========================================
REM RELANCER SERVEUR
REM ==========================================
:restart_server
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║                  ▶️  Redémarrage du Serveur                    ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo %INFO% Données conservées
echo %INFO% Serveur sur: http://localhost:8000
echo.
echo Appuyez sur Ctrl+C pour arrêter le serveur
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

REM ==========================================
REM REINITIALISER BD
REM ==========================================
:reset_db
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║            🔄 Réinitialisation Base de Données                 ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo %INFO% Cela va supprimer et recréer la BD avec:
echo      • Tables: users, categories, products, orders, order_items
echo      • 35 produits premium
echo      • 6 utilisateurs de test
echo.

set /p confirm="Êtes-vous sûr? (O/N): "
if /i not "%confirm%"=="O" (
    echo %INFO% Annulé
    pause
    goto end
)

echo.
echo %INFO% Réinitialisation en cours...

if !FOUND_PHP! equ 1 (
    set "DB_HOST=localhost"
    set "DB_USER=!DB_USER!"
    set "DB_PASS=!DB_PASS!"
    php "%~dp0start_novashop.php"
    if errorlevel 1 (
        echo %WARN% PHP a échoué, essai avec MySQL CLI...
        if !FOUND_MYSQL! equ 1 (
            call :init_db_mysql
            if errorlevel 1 (
                echo %ERROR% Erreur lors de l'initialisation!
                pause
                goto end
            )
        ) else (
            echo %ERROR% PHP et MySQL non disponibles!
            pause
            goto end
        )
    )
) else if !FOUND_MYSQL! equ 1 (
    call :init_db_mysql
    if errorlevel 1 (
        echo %ERROR% Erreur lors de l'initialisation!
        pause
        goto end
    )
) else (
    echo %ERROR% PHP et MySQL non trouvés!
    pause
    goto end
)
echo %SUCCESS% BD réinitialisée avec succès!
echo.

echo %INFO% Démarrage du serveur...
echo %INFO% Serveur sur: http://localhost:8000
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

REM ==========================================
REM TELECHARGER IMAGES PRODUITS
REM ==========================================
:download_images
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║         📥 Téléchargement des Images Produits (35)             ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo %INFO% Va télécharger 35 photos depuis LoremFlickr...
echo %INFO% Destination: Public/Assets/Images/products/
echo.
pause

php "%~dp0Public/Assets/Images/download_images.php"
if errorlevel 1 (
    echo %ERROR% Erreur lors du téléchargement
    echo %INFO% Assurez-vous d'avoir une connexion internet
    pause
    goto end
)

echo.
echo %SUCCESS% 35 images téléchargées avec succès!
echo.
pause
goto end

REM ==========================================
REM NETTOYER CACHE NAVIGATEUR
REM ==========================================
:clear_cache
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║            🧹 Nettoyage Cache Navigateur                      ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo %INFO% Instructions pour nettoyer le cache:
echo.
echo 📝 Méthode 1 - Chrome/Edge/Firefox:
echo    1. Ouvrez http://localhost:8000
echo    2. Appuyez sur F12 (Developer Tools)
echo    3. Allez dans: Application ^> Storage
echo    4. Cliquez: Clear Site Data
echo    5. Fermez DevTools (F12)
echo    6. Appuyez sur Ctrl+Shift+R (hard refresh)
echo.
echo 📝 Méthode 2 - Raccourci clavier:
echo    • Chrome/Edge/Firefox: Ctrl+Shift+Delete
echo    • Puis cochez: Cookies, Cache, Local Storage
echo    • Cliquez: Clear data
echo.
echo 📝 Méthode 3 - Hard refresh:
echo    1. Appuyez sur Ctrl+F5 (Windows)
echo    2. Ou: Cmd+Shift+R (Mac)
echo.
echo %SUCCESS% Cache nettoyé!
pause
goto end

REM ==========================================
REM RESET COMPLET
REM ==========================================
:full_reset
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║        ⚠️  RESET COMPLET - Tout Sera Effacé!                  ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo %ERROR% Attention! Cette action va:
echo      • Supprimer la base de données 'novashop'
echo      • Effacer toutes les commandes et utilisateurs
echo      • Supprimer les images du cache local
echo      • Recréer un système vierge avec 35 produits
echo.

set /p confirm1="Confirmez? Tapez OUI (en majuscules): "
if not "%confirm1%"=="OUI" (
    echo %INFO% Reset annulé
    pause
    goto end
)

echo.
echo %INFO% Reset en cours...
echo.

REM Supprimer les images locales
if exist "%~dp0\Public\Assets\Images\products\*" (
    echo %INFO% Suppression des images téléchargées...
    del /q "%~dp0\Public\Assets\Images\products\*" >nul 2>&1
)

REM Réinitialiser BD
echo %INFO% Recréation de la base de données...

if !FOUND_PHP! equ 1 (
    set "DB_HOST=localhost"
    set "DB_USER=!DB_USER!"
    set "DB_PASS=!DB_PASS!"
    php "%~dp0start_novashop.php"
    if errorlevel 1 (
        echo %WARN% PHP a échoué, essai avec MySQL CLI...
        if !FOUND_MYSQL! equ 1 (
            call :init_db_mysql
            if errorlevel 1 (
                echo %ERROR% Erreur lors du reset!
                pause
                goto end
            )
        ) else (
            echo %ERROR% PHP et MySQL non disponibles!
            pause
            goto end
        )
    )
) else if !FOUND_MYSQL! equ 1 (
    call :init_db_mysql
    if errorlevel 1 (
        echo %ERROR% Erreur lors du reset!
        pause
        goto end
    )
) else (
    echo %ERROR% PHP et MySQL non trouvés!
    pause
    goto end
)

echo %SUCCESS% Reset complet terminé!
echo.
echo %INFO% Démarrage du serveur...
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

REM ==========================================
REM FIN
REM ==========================================
:end
echo.
echo À bientôt!
echo.
pause
exit /b 0
for /d %%G in ("C:\Program Files (x86)\MySQL*") do (
    if exist "%%G\bin\mysql.exe" (
        set MYSQL_PATH=%%G\bin\mysql.exe
        goto found_mysql
    )
)

REM Pas trouve - afficher erreur
echo.
echo [ERREUR] MySQL/MariaDB non trouve!
echo.
echo Solutions:
echo 1. Installer MariaDB: https://mariadb.org/download
echo 2. Ou installer MySQL: https://dev.mysql.com/downloads/mysql/
echo 3. Assurez-vous que le chemin d'installation est standard
echo    (C:\Program Files\MariaDB* ou C:\Program Files\MySQL*)
echo.
pause
goto end

:found_mysql
echo [OK] Trouve: !MYSQL_PATH!
echo.

echo.
echo [NETTOYAGE] Nettoyage et redemarrage de NovaShop Pro...
echo.

REM Option 1: Reset BD complete
echo Quelle action voulez-vous faire?
echo 1. Redemarrer serveur (recommande)
echo 2. Reinitialiser la BD complete
echo 3. Effacer cache navigateur et redemarrer
echo 4. Tout effacer et repartir de zero
echo.

set /p choice="Choisissez (1-4): "

if "%choice%"=="1" goto restart_server
if "%choice%"=="2" goto reset_db
if "%choice%"=="3" goto clear_cache
if "%choice%"=="4" goto full_reset

goto invalid

:restart_server
echo.
echo [OK] Redemarrage du serveur...
echo Assurez-vous que le serveur n'est PAS deja lance
echo (Si oui: appuyez sur Ctrl+C pour l'arreter d'abord)
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

:reset_db
echo.
echo [TRAITEMENT] Reinitialisation complete avec donnees premium...
echo.

php "%~dp0start_novashop.php"
if errorlevel 1 (
    echo.
    echo [ERREUR] Erreur lors de l'initialisation
    pause
    goto end
)

echo.
echo [OK] Demarrage du serveur...
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

:clear_cache
echo.
echo [NETTOYAGE] Instructions de nettoyage navigateur:
echo.
echo 1. Ouvrez http://localhost:8000
echo 2. Appuyez sur F12 (DevTools)
echo 3. Application - Cookies - http://localhost:8000 - Delete All
echo 4. Application - LocalStorage - Delete All
echo 5. Fermez DevTools (F12)
echo 6. Appuyez sur Ctrl+Shift+R (hard refresh)
echo.
echo [OK] Cache efface!
echo Maintenant relancez le serveur...
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

:full_reset
echo.
echo [ATTENTION] Cela reinitialisant TOUT avec donnees premium
echo.

echo Continuez? (Y/N)
set /p confirm="Confirmer: "
if /i not "%confirm%"=="Y" goto end

echo.
echo [TRAITEMENT] Reset complet...
echo.

php "%~dp0start_novashop.php"
if errorlevel 1 (
    echo.
    echo [ERREUR] Erreur lors de l'initialisation
    pause
    goto end
)

echo.
echo [OK] Demarrage du serveur...
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

:invalid
echo.
echo [ERREUR] Choix invalide
echo.
pause
goto end

REM ==========================================
REM FONCTION: Initialiser BD avec MySQL CLI
REM ==========================================
:init_db_mysql
setlocal enabledelayedexpansion

echo %INFO% Initialisation de la BD avec MySQL CLI...

if defined MYSQL_PATH (
    set "MYSQL_CMD=!MYSQL_PATH!"
) else (
    set "MYSQL_CMD=mysql.exe"
)

REM Tester la connexion
!MYSQL_CMD! -u !DB_USER! -p!DB_PASS! -e "SELECT 1" >nul 2>&1
if !errorlevel! neq 0 (
    echo %ERROR% Impossible de se connecter à MySQL/MariaDB
    echo.
    echo   Vérifiez que:
    echo   • MariaDB est en cours d'exécution
    echo   • L'utilisateur !DB_USER! existe
    echo   • Le mot de passe configuré est correct
    echo.
    exit /b 1
)

echo %INFO% Suppression de la base de données existante...
!MYSQL_CMD! -u !DB_USER! -p!DB_PASS! -e "DROP DATABASE IF EXISTS novashop" >nul 2>&1

echo %INFO% Création de la nouvelle base de données...
!MYSQL_CMD! -u !DB_USER! -p!DB_PASS! -e "CREATE DATABASE novashop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci" >nul 2>&1

echo %INFO% Création des tables...
!MYSQL_CMD! -u !DB_USER! -p!DB_PASS! novashop < "%~dp0setup.sql" >nul 2>&1
if !errorlevel! neq 0 (
    echo %ERROR% Erreur lors de la création des tables
    exit /b 1
)

echo %INFO% Insertion des données premium...
!MYSQL_CMD! -u !DB_USER! -p!DB_PASS! novashop < "%~dp0seed_premium.sql" >nul 2>&1
if !errorlevel! neq 0 (
    echo %WARN% Données premium non importées, import standard...
    !MYSQL_CMD! -u !DB_USER! -p!DB_PASS! novashop < "%~dp0seed.sql" >nul 2>&1
)

echo %SUCCESS% Base de données initialisée!
exit /b 0

:end
echo.
echo Au revoir!
echo.
pause
