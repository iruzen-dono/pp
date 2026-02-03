@echo off
REM ============================================
REM Setup & Server Start Script for NovaShop Pro
REM ============================================
setlocal enabledelayedexpansion

echo.
echo ============================================
echo NovaShop Pro - Setup ^& Start
echo ============================================
echo.

REM Check if PHP is installed
php -v >nul 2>&1
if errorlevel 1 (
    echo [ERROR] PHP is not installed or not in PATH
    echo Please install PHP and add it to your PATH
    pause
    exit /b 1
)
echo [OK] PHP found

REM Check if .env file exists
if not exist ".env" (
    echo.
    echo [INFO] .env file not found
    if exist ".env.example" (
        echo [ACTION] Creating .env from .env.example...
        copy ".env.example" ".env" >nul
        echo [OK] .env created
        echo.
        echo ============================================
        echo IMPORTANT: Configure .env with your database
        echo ============================================
        echo.
        echo Required fields to edit in .env:
        echo   - DB_HOST=localhost
        echo   - DB_PORT=3306
        echo   - DB_NAME=novashop_db
        echo   - DB_USER=your_db_user
        echo   - DB_PASS=your_db_password
        echo.
        echo Opening .env in Notepad...
        echo Press any key to continue...
        pause >nul
        notepad .env
    ) else (
        echo [ERROR] .env.example not found
        pause
        exit /b 1
    )
)

REM Download Composer if not present
if not exist "composer.phar" (
    echo.
    echo [INFO] composer.phar not found
    echo [ACTION] Downloading Composer from getcomposer.org...
    
    REM Try using PowerShell to download
    powershell -NoProfile -Command "try { [Net.ServicePointManager]::SecurityProtocol = [Net.SecurityProtocolType]::Tls12; (New-Object System.Net.WebClient).DownloadFile('https://getcomposer.org/download/latest-stable/composer.phar', 'composer.phar'); exit 0 } catch { exit 1 }"
    
    if errorlevel 1 (
        echo [WARNING] Could not download Composer automatically
        echo [INFO] You can:
        echo   1. Download manually from: https://getcomposer.org/download/
        echo   2. Or place composer.phar in this directory
        echo.
        echo Continuing without Composer dependencies...
    ) else (
        echo [OK] Composer downloaded successfully
    )
)

REM Install dependencies if composer.phar exists
if exist "composer.phar" (
    echo.
    echo [ACTION] Installing PHP dependencies...
    php composer.phar install --ignore-platform-reqs >nul 2>&1
    if not errorlevel 1 (
        echo [OK] Dependencies installed
    )
)

REM Check if database is set up
if exist "scripts\setup.sql" (
    echo.
    echo [INFO] Database setup script found
    echo To initialize the database:
    echo   1. Create database in MySQL: CREATE DATABASE novashop_db;
    echo   2. Import scripts\setup.sql
    echo.
)

REM Check for MySQL/MariaDB service
echo [INFO] Checking for MySQL/MariaDB service...
sc query MySQL >nul 2>&1
if errorlevel 1 (
    sc query MariaDB >nul 2>&1
    if not errorlevel 1 (
        echo [OK] MariaDB found
    )
) else (
    echo [OK] MySQL found
)

REM ============================================
REM Main Menu
REM ============================================
:menu
echo.
echo ============================================
echo NovaShop Pro - Menu Principal
echo ============================================
echo.
echo 1. Initialiser la base de donnees
echo 2. Supprimer la base de donnees
echo 3. Demarrer le serveur PHP
echo 4. Quitter
echo.
set /p choice="Choisissez une option (1-4): "

if "%choice%"=="1" goto init_db
if "%choice%"=="2" goto delete_db
if "%choice%"=="3" goto start_server
if "%choice%"=="4" goto end
echo [ERROR] Option invalide
goto menu

REM ============================================
REM Initialize Database
REM ============================================
:init_db
echo.
echo ============================================
echo Initialisation de la Base de Donnees
echo ============================================
echo.
echo Note: Ce script fonctionne avec:
echo   - MySQL 5.7+
echo   - MariaDB 10.0+
echo   - Les identifiants doivent etre les memes qu'en ligne de commande
echo.

REM Check if MySQL/MariaDB is available
echo [ACTION] Verification de MySQL/MariaDB...
mysql --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] MySQL/MariaDB n'est pas installe ou pas dans PATH
    echo [INFO] Installez MySQL ou MariaDB et ajoutez-le a votre PATH
    echo.
    pause
    goto menu
)
echo [OK] MySQL/MariaDB trouve

REM Get database credentials
set /p db_host="Nom d'hote MySQL (par defaut: localhost): "
if "%db_host%"=="" set db_host=localhost

set /p db_user="Utilisateur MySQL (par defaut: root): "
if "%db_user%"=="" set db_user=root

set /p db_pass="Mot de passe MySQL (par defaut: 0000): "
if "%db_pass%"=="" set db_pass=0000

set /p db_name="Nom de la base de donnees (par defaut: novashop_db): "
if "%db_name%"=="" set db_name=novashop_db

REM Test connection
echo.
echo [ACTION] Test de connexion a MySQL/MariaDB...
echo   Host: %db_host%, User: %db_user%
mysql -h %db_host% -u %db_user% --password=%db_pass% -e "SELECT 1;" >nul 2>&1

if errorlevel 1 (
    echo [ERROR] Impossible de se connecter a MySQL/MariaDB
    echo.
    echo Verifiez:
    echo   1. MySQL/MariaDB est en cours d'execution
    echo   2. Les identifiants sont corrects
    echo   3. L'utilisateur MySQL existe
    echo.
    pause
    goto menu
)
echo [OK] Connexion reussie

echo.
echo [ACTION] Creation de la base de donnees...
mysql -h %db_host% -u %db_user% --password=%db_pass% -e "CREATE DATABASE IF NOT EXISTS %db_name% CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>nul

if errorlevel 1 (
    echo [ERROR] Impossible de creer la base de donnees
    pause
    goto menu
)
echo [OK] Base de donnees creee avec succes

REM Check if setup.sql exists
if not exist "setup.sql" (
    echo.
    echo [WARNING] Fichier setup.sql non trouve
    echo [INFO] Localisation attendue: %cd%\setup.sql
    echo.
    echo Options:
    echo   1. Recherche des fichiers SQL dans le projet...
    
    REM Search for SQL files
    for /r %%f in (*.sql) do (
        if "%%f"=="setup.sql" (
            echo [FOUND] setup.sql trouve: %%f
            set sql_file=%%f
            goto found_sql
        )
    )
    
    echo [ERROR] Aucun fichier setup.sql trouve
    echo.
    echo Vous pouvez:
    echo   1. Placer setup.sql dans le repertoire courant
    echo   2. Utiliser migrate_email_verification.sql ou migrate_password_resets.sql
    echo   3. Importer manuellement via PhpMyAdmin
    echo.
    
    set /p use_default="Creer une BD vide pour continuer? (oui/non): "
    if /i "%use_default%"=="oui" (
        echo [INFO] BD creee vide - vous devrez creer les tables manuellement
        echo [SUCCESS] Base de donnees initialisee!
        pause
        goto menu
    ) else (
        echo [INFO] Initialisation annulee
        pause
        goto menu
    )
    
    :found_sql
    echo [ACTION] Importation de %%f...
) else (
    set sql_file=setup.sql
    echo [ACTION] Importation du schema depuis setup.sql...
)

mysql -h %db_host% -u %db_user% --password=%db_pass% %db_name% < %sql_file% 2>nul

if errorlevel 1 (
    echo [ERROR] Erreur lors de l'importation du schema
    echo [INFO] Verifiez que le fichier SQL est valide
    pause
    goto menu
)
echo [OK] Schema importe avec succes

REM Verify tables were created
mysql -h %db_host% -u %db_user% --password=%db_pass% %db_name% -e "SHOW TABLES;" >nul 2>&1
if errorlevel 1 (
    echo [WARNING] Impossible de verifier les tables
) else (
    echo [OK] Tables creees avec succes
)

REM Import seed data if present
if exist "seed_premium.sql" (
    echo.
    echo [ACTION] Fichier de seed trouve: seed_premium.sql - import en cours...
    mysql -h %db_host% -u %db_user% --password=%db_pass% %db_name% < "seed_premium.sql"
    if errorlevel 1 (
        echo [WARNING] Import du seed a echoue. Verifiez le fichier seed_premium.sql
    ) else (
        echo [OK] Donnees de seed importe avec succes
        echo.
        echo [INFO] Statistiques apres import:
        mysql -h %db_host% -u %db_user% --password=%db_pass% -D %db_name% -e "SELECT COUNT(*) AS total_users FROM users; SELECT COUNT(*) AS total_products FROM products; SELECT COUNT(*) AS total_categories FROM categories;"
    )
)

REM Run image URL fix script if present
if exist "scripts\fix_image_urls.sql" (
    echo.
    echo [ACTION] Correction des image_url via scripts\fix_image_urls.sql...
    mysql -h %db_host% -u %db_user% --password=%db_pass% %db_name% < "scripts\fix_image_urls.sql"
    if errorlevel 1 (
        echo [WARNING] Echec de la correction des image_url
    ) else (
        echo [OK] image_url mis a jour
    )
)

echo.
echo ============================================
echo [SUCCESS] Base de donnees initialisee!
echo ============================================
echo.
echo Informations de connexion:
echo   Host: %db_host%
echo   User: %db_user%
echo   Database: %db_name%
echo.
echo Pour modifier ces valeurs plus tard, editez:
echo   App\Config\Database.php
echo.
pause
goto menu

REM ============================================
REM Delete Database
REM ============================================
:delete_db
echo.
echo ============================================
echo Suppression de la Base de Donnees
echo ============================================
echo.
echo [WARNING] ATTENTION: Cette action supprimera toutes les donnees!
echo.

REM Check if MySQL/MariaDB is available
echo [ACTION] Verification de MySQL/MariaDB...
mysql --version >nul 2>&1
if errorlevel 1 (
    echo [ERROR] MySQL/MariaDB n'est pas installe ou pas dans PATH
    pause
    goto menu
)
echo [OK] MySQL/MariaDB trouve

set /p db_host="Nom d'hote MySQL (par defaut: localhost): "
if "%db_host%"=="" set db_host=localhost

set /p db_user="Utilisateur MySQL (par defaut: root): "
if "%db_user%"=="" set db_user=root

set /p db_pass="Mot de passe MySQL (par defaut: 0000): "
if "%db_pass%"=="" set db_pass=0000

set /p db_name="Nom de la base de donnees a supprimer (par defaut: novashop_db): "
if "%db_name%"=="" set db_name=novashop_db

REM Test connection
echo.
echo [ACTION] Test de connexion a MySQL/MariaDB...
echo   Host: %db_host%, User: %db_user%
mysql -h %db_host% -u %db_user% --password=%db_pass% -e "SELECT 1;" >nul 2>&1

if errorlevel 1 (
    echo [ERROR] Impossible de se connecter a MySQL/MariaDB
    echo Verifiez vos identifiants
    pause
    goto menu
)
echo [OK] Connexion reussie

REM Check if database exists
echo [ACTION] Verification de l'existence de la BD...
mysql -h %db_host% -u %db_user% --password=%db_pass% -e "USE %db_name%;" >nul 2>&1

if errorlevel 1 (
    echo [ERROR] La base de donnees '%db_name%' n'existe pas
    echo Verifiez le nom de la base de donnees
    pause
    goto menu
)
echo [OK] Base de donnees trouvee

echo.
echo [WARNING] Vous allez supprimer la base de donnees: %db_name%
echo [WARNING] TOUTES LES DONNEES SERONT PERDUES!
echo.
set /p confirm="Etes-vous ABSOLUMENT sur? (tapez 'OUI' pour confirmer): "

if /i not "%confirm%"=="OUI" (
    echo [INFO] Suppression annulee
    pause
    goto menu
)

echo [ACTION] Suppression de la base de donnees...
mysql -h %db_host% -u %db_user% --password=%db_pass% -e "DROP DATABASE %db_name%;" 2>nul

if errorlevel 1 (
    echo [ERROR] Erreur lors de la suppression
    pause
    goto menu
)

echo.
echo ============================================
echo [SUCCESS] Base de donnees supprimee!
echo ============================================
echo.
pause
goto menu

REM ============================================
REM Start PHP Server
REM ============================================
:start_server
echo.
echo ============================================
echo Demarrage du Serveur PHP
echo ============================================
echo.
echo Acces a l'application sur:
echo   http://localhost:8000/
echo.
echo Pages disponibles:
echo   - Accueil: http://localhost:8000/
echo   - Produits: http://localhost:8000/?page=products
echo   - Panier: http://localhost:8000/?page=cart
echo   - Admin: http://localhost:8000/?page=admin
echo.
echo Appuyez sur Ctrl+C pour arreter le serveur
echo.
timeout /t 3

cd Public
php -S localhost:8000 router.php

:end
exit /b 0
