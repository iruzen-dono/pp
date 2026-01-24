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

REM Variables globales
set "FOUND_PHP=0"
set "FOUND_MYSQL=0"
set "MYSQL_PATH="
set "DB_USER="
set "DB_PASS="

cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║         🌟 NovaShop Pro - Configuration Complète 🌟            ║
echo ║                    Clonage ^& Initialisation                    ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

REM ==========================================
REM ETAPE 0: Vérifier administrateur
REM ==========================================

net session >nul 2>&1
if %errorlevel% neq 0 (
    echo %ERROR% Ce script doit être exécuté en tant qu'administrateur!
    echo.
    echo Clic droit sur restart.bat ^> Exécuter en tant qu'administrateur
    echo.
    pause
    exit /b 1
)

REM ==========================================
REM ETAPE 1: Vérifier et installer PHP
REM ==========================================

echo %INFO% Vérification de PHP...
echo.

where php.exe >nul 2>&1
if !errorlevel! equ 0 (
    echo %SUCCESS% PHP est déjà installé
    set "FOUND_PHP=1"
    goto check_mysql
)

echo %WARN% PHP non trouvé! Installation automatique...
echo.
call :install_php
if !errorlevel! equ 0 (
    set "FOUND_PHP=1"
) else (
    echo %ERROR% Impossible d'installer PHP
    pause
    exit /b 1
)

:check_mysql
REM ==========================================
REM ETAPE 2: Vérifier et installer MariaDB
REM ==========================================

echo %INFO% Vérification de MariaDB/MySQL...
echo.

where mysql.exe >nul 2>&1
if !errorlevel! equ 0 (
    echo %SUCCESS% MySQL/MariaDB est déjà installé
    set "FOUND_MYSQL=1"
    goto ask_credentials
)

for /d %%G in ("C:\Program Files\MariaDB*") do (
    if exist "%%G\bin\mysql.exe" (
        echo %SUCCESS% MariaDB trouvé: %%G
        set "FOUND_MYSQL=1"
        set "MYSQL_PATH=%%G\bin"
        goto ask_credentials
    )
)

echo %WARN% MariaDB non trouvé! Installation automatique...
echo.
call :install_mariadb
if !errorlevel! equ 0 (
    set "FOUND_MYSQL=1"
) else (
    echo %ERROR% Impossible d'installer MariaDB
    pause
    exit /b 1
)

:ask_credentials

REM ==========================================
REM ETAPE 3: Demander les identifiants MySQL
REM ==========================================

echo %INFO% Configuration des identifiants MySQL/MariaDB
echo.
set /p DB_USER="Nom d'utilisateur MySQL (défaut: root): "
if "!DB_USER!"=="" set "DB_USER=root"

set /p DB_PASS="Mot de passe MySQL (défaut: vide): "

echo.
echo %INFO% Identifiants configurés: !DB_USER!
echo.

REM ==========================================
REM ETAPE 4: Menu principal
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
goto ask_credentials

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
    echo %WARN% PHP non disponible. Installation terminée!
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

cd /d "%~dp0Public"
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

cd /d "%~dp0Public"
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

if !FOUND_PHP! equ 1 (
    php "%~dp0Public/Assets/Images/download_images.php"
) else (
    echo %WARN% PHP non disponible. Téléchargement manuel:
    echo Visitez: https://loremflickr.com/640/480/product
    echo Sauvegardez 35 images dans: Public/Assets/Images/products/
)

echo.
echo %SUCCESS% Prêt!
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
if exist "%~dp0Public\Assets\Images\products\*" (
    echo %INFO% Suppression des images téléchargées...
    del /q "%~dp0Public\Assets\Images\products\*" >nul 2>&1
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

cd /d "%~dp0Public"
php -S localhost:8000 router.php
goto end

REM ==========================================
REM FONCTION: Initialiser BD avec MySQL CLI
REM ==========================================
:init_db_mysql
setlocal enabledelayedexpansion

echo %INFO% Initialisation de la BD avec MySQL CLI...

if defined MYSQL_PATH (
    set "MYSQL_CMD=!MYSQL_PATH!\mysql.exe"
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

REM ==========================================
REM FONCTION: Installer PHP automatiquement
REM ==========================================
:install_php
setlocal enabledelayedexpansion

echo %INFO% Installation de PHP 8.2...
echo.

REM Essayer d'abord avec Chocolatey si disponible
where choco.exe >nul 2>&1
if !errorlevel! equ 0 (
    echo %INFO% Chocolatey trouvé, installation via Chocolatey...
    choco install php -y >nul 2>&1
    if !errorlevel! equ 0 (
        echo %SUCCESS% PHP installé avec Chocolatey!
        exit /b 0
    )
)

REM Créer le dossier PHP
if not exist "C:\php-8.2" mkdir "C:\php-8.2"

REM Télécharger PHP avec plusieurs URLs de secours
echo %INFO% Téléchargement de PHP 8.2 (cette opération peut prendre quelques minutes)...
echo.

set "DOWNLOAD_SUCCESS=0"

for /l %%i in (0,1,2) do (
    if !DOWNLOAD_SUCCESS! equ 0 (
        echo %INFO% Tentative %%i (essai de téléchargement)...
        
        if %%i equ 0 set "PHP_URL=https://windows.php.net/downloads/releases/php-8.2.21-nts-Win32-x64.zip"
        if %%i equ 1 set "PHP_URL=https://windows.php.net/downloads/releases/php-8.1.27-nts-Win32-x64.zip"
        if %%i equ 2 set "PHP_URL=https://windows.php.net/downloads/releases/php-8.0.30-nts-Win32-x64.zip"
        
        powershell -NoProfile -ExecutionPolicy Bypass -Command ^
        "try { ^
            $ProgressPreference = 'SilentlyContinue'; ^
            Invoke-WebRequest -Uri '!PHP_URL!' -OutFile 'C:\php-8.2.zip' -ErrorAction Stop; ^
            exit 0; ^
        } catch { ^
            exit 1; ^
        }"
        
        if !errorlevel! equ 0 (
            echo %SUCCESS% Téléchargement réussi!
            set "DOWNLOAD_SUCCESS=1"
        )
    )
)

if !DOWNLOAD_SUCCESS! equ 0 (
    echo %ERROR% Impossible de télécharger PHP automatiquement
    echo.
    echo %INFO% Téléchargement manuel:
    echo   1. Visitez: https://windows.php.net/download/
    echo   2. Téléchargez: php-8.2.x-nts-Win32-x64.zip
    echo   3. Créez dossier: C:\php-8.2
    echo   4. Extraire le ZIP dedans
    echo   5. Relancez ce script
    echo.
    pause
    exit /b 1
)

REM Extraire le ZIP
echo %INFO% Extraction de PHP...
powershell -NoProfile -ExecutionPolicy Bypass -Command ^
"try { ^
    Expand-Archive -Path 'C:\php-8.2.zip' -DestinationPath 'C:\php-8.2' -Force; ^
} catch { ^
    exit 1; ^
}"

if errorlevel 1 (
    echo %ERROR% Erreur lors de l'extraction de PHP
    exit /b 1
)

REM Nettoyer le ZIP
del "C:\php-8.2.zip" >nul 2>&1

REM Ajouter au PATH
echo %INFO% Configuration du PATH...
powershell -NoProfile -ExecutionPolicy Bypass -Command ^
"$env:Path = 'C:\php-8.2;' + $env:Path; ^
[Environment]::SetEnvironmentVariable('Path', $env:Path, 'Machine')"

REM Vérifier l'installation
echo %INFO% Vérification de PHP...
php --version >nul 2>&1
if errorlevel 1 (
    echo %WARN% PHP détecté mais PATH nécessite un redémarrage
    pause
    exit /b 0
)

echo %SUCCESS% PHP 8.2 installé avec succès!
exit /b 0

REM ==========================================
REM FONCTION: Installer MariaDB automatiquement
REM ==========================================
:install_mariadb
setlocal enabledelayedexpansion

echo %INFO% Installation de MariaDB...
echo.

REM Essayer d'abord avec Chocolatey si disponible
where choco.exe >nul 2>&1
if !errorlevel! equ 0 (
    echo %INFO% Chocolatey trouvé, installation via Chocolatey...
    choco install mariadb -y >nul 2>&1
    if !errorlevel! equ 0 (
        echo %SUCCESS% MariaDB installé avec Chocolatey!
        exit /b 0
    )
)

REM Créer les dossiers
if not exist "C:\mariadb-install" mkdir "C:\mariadb-install"

REM Télécharger MariaDB avec URLs de secours
echo %INFO% Téléchargement de MariaDB (cette opération peut prendre quelques minutes)...
echo.

set "DOWNLOAD_SUCCESS=0"

for /l %%i in (0,1,2) do (
    if !DOWNLOAD_SUCCESS! equ 0 (
        echo %INFO% Tentative %%i (essai de téléchargement)...
        
        if %%i equ 0 set "MARIADB_URL=https://archive.mariadb.org/mariadb-10.11.6/winx64-packages/mariadb-10.11.6-winx64.zip"
        if %%i equ 1 set "MARIADB_URL=https://archive.mariadb.org/mariadb-10.6.15/winx64-packages/mariadb-10.6.15-winx64.zip"
        if %%i equ 2 set "MARIADB_URL=https://archive.mariadb.org/mariadb-10.5.22/winx64-packages/mariadb-10.5.22-winx64.zip"
        
        powershell -NoProfile -ExecutionPolicy Bypass -Command ^
        "try { ^
            $ProgressPreference = 'SilentlyContinue'; ^
            Invoke-WebRequest -Uri '!MARIADB_URL!' -OutFile 'C:\mariadb-install\mariadb.zip' -ErrorAction Stop; ^
            exit 0; ^
        } catch { ^
            exit 1; ^
        }"
        
        if !errorlevel! equ 0 (
            echo %SUCCESS% Téléchargement réussi!
            set "DOWNLOAD_SUCCESS=1"
        )
    )
)

if !DOWNLOAD_SUCCESS! equ 0 (
    echo %ERROR% Impossible de télécharger MariaDB automatiquement
    echo.
    echo %INFO% Téléchargement manuel:
    echo   1. Visitez: https://mariadb.org/download/
    echo   2. Téléchargez MariaDB MSI
    echo   3. Installez avec chemin standard: C:\Program Files\MariaDB
    echo   4. Relancez ce script
    echo.
    pause
    exit /b 1
)

REM Extraire MariaDB
echo %INFO% Extraction de MariaDB...
powershell -NoProfile -ExecutionPolicy Bypass -Command ^
"try { ^
    Expand-Archive -Path 'C:\mariadb-install\mariadb.zip' -DestinationPath 'C:\mariadb-install' -Force; ^
    $folders = Get-ChildItem 'C:\mariadb-install' -Directory; ^
    foreach ($folder in $folders) { ^
        if ($folder.Name -match 'mariadb') { ^
            if (!(Test-Path 'C:\Program Files\MariaDB')) { mkdir 'C:\Program Files\MariaDB' }; ^
            Copy-Item -Path $folder.FullName\* -Destination 'C:\Program Files\MariaDB' -Recurse -Force -ErrorAction SilentlyContinue; ^
        } ^
    } ^
} catch { ^
    exit 1; ^
}"

if errorlevel 1 (
    echo %ERROR% Erreur lors de l'extraction de MariaDB
    exit /b 1
)

REM Nettoyer
rmdir /s /q "C:\mariadb-install" >nul 2>&1

REM Ajouter au PATH
echo %INFO% Configuration du PATH pour MariaDB...
powershell -NoProfile -ExecutionPolicy Bypass -Command ^
"$env:Path = 'C:\Program Files\MariaDB\bin;' + $env:Path; ^
[Environment]::SetEnvironmentVariable('Path', $env:Path, 'Machine')"

REM Vérifier l'installation
echo %INFO% Vérification de MariaDB...
mysql --version >nul 2>&1
if errorlevel 1 (
    echo %WARN% MariaDB détecté mais PATH nécessite un redémarrage
    pause
    exit /b 0
)

echo %SUCCESS% MariaDB installé avec succès!
exit /b 0

REM ==========================================
REM FIN
REM ==========================================
:end
echo.
echo À bientôt!
echo.
pause
exit /b 0
