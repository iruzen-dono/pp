@echo off
REM ==========================================
REM NovaShop Pro - Clean Restart Script
REM Auto-Detection de MariaDB/MySQL
REM Compatible avec tous les chemins d'installation
REM ==========================================

setlocal enabledelayedexpansion
set DB_USER=root
set DB_PASS=0000

REM ==========================================
REM ÉTAPE 1: Détection automatique de MySQL/MariaDB
REM ==========================================

set MYSQL_PATH=

REM Essayer où mysql commande directement (si dans PATH)
where mysql.exe >nul 2>&1
if !errorlevel! equ 0 (
    for /f "delims=" %%i in ('where mysql.exe') do set MYSQL_PATH=%%i
    goto found_mysql
)

REM Chercher MariaDB (versions multiples)
for /d %%G in ("C:\Program Files\MariaDB*") do (
    if exist "%%G\bin\mysql.exe" (
        set MYSQL_PATH=%%G\bin\mysql.exe
        goto found_mysql
    )
)

REM Chercher MySQL (versions multiples)
for /d %%G in ("C:\Program Files\MySQL*") do (
    if exist "%%G\bin\mysql.exe" (
        set MYSQL_PATH=%%G\bin\mysql.exe
        goto found_mysql
    )
)

REM Chercher en Program Files (x86) pour MariaDB
for /d %%G in ("C:\Program Files (x86)\MariaDB*") do (
    if exist "%%G\bin\mysql.exe" (
        set MYSQL_PATH=%%G\bin\mysql.exe
        goto found_mysql
    )
)

REM Chercher en Program Files (x86) pour MySQL
for /d %%G in ("C:\Program Files (x86)\MySQL*") do (
    if exist "%%G\bin\mysql.exe" (
        set MYSQL_PATH=%%G\bin\mysql.exe
        goto found_mysql
    )
)

REM Pas trouvé - afficher erreur
echo.
echo ❌ ERREUR: MySQL/MariaDB non trouvé!
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
echo ✅ Trouvé: !MYSQL_PATH!
echo.

echo.
echo 🧹 Nettoyage et redémarrage de NovaShop Pro...
echo.

REM Option 1: Reset BD complète
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
echo ✅ Redemarrage du serveur...
echo Assurez-vous que le serveur n'est PAS deja lance
echo (Si oui: appuyez sur Ctrl+C pour l'arreter d'abord)
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

:reset_db
echo.
echo 🔄 Reinitialisation de la base de donnees...
echo.

REM Vérifier que MariaDB est lancé
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% -e "SELECT 1" >nul 2>&1
if errorlevel 1 (
    echo ❌ Erreur: MariaDB n'est pas accessible
    echo Assurez-vous que le service MariaDB est lancé!
    pause
    goto end
)

REM Supprimer et recréer la BD
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% -e "DROP DATABASE IF EXISTS novashop;" >nul 2>&1
echo ✅ Ancienne BD supprimée

REM Recréer la BD avec données
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% < setup.sql
if errorlevel 1 (
    echo ❌ Erreur lors de la creation de la BD
    pause
    goto end
) else (
    echo ✅ BD creee avec succes
)

echo.
echo ✅ Redemarrage du serveur...
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

:clear_cache
echo.
echo 🗑️  Instructions de nettoyage navigateur:
echo.
echo 1. Ouvrez http://localhost:8000
echo 2. Appuyez sur F12 (DevTools)
echo 3. Application > Cookies > http://localhost:8000 > Delete All
echo 4. Application > LocalStorage > Delete All
echo 5. Fermez DevTools (F12)
echo 6. Appuyez sur Ctrl+Shift+R (hard refresh)
echo.
echo ✅ Cache efface!
echo Maintenant relancez le serveur...
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

:full_reset
echo.
echo ⚠️  ATTENTION: Cela supprimera TOUT
echo.
echo Continuez? (Y/N)
set /p confirm="Confirmer: "
if /i not "%confirm%"=="Y" goto end

echo.
echo 🔄 Reset complet...
echo.

REM Supprimer BD
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% -e "DROP DATABASE IF EXISTS novashop;" >nul 2>&1
echo ✅ BD supprimee

REM Recréer BD
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% < setup.sql
if errorlevel 1 (
    echo ❌ Erreur lors de la creation de la BD
    pause
    goto end
) else (
    echo ✅ BD creee avec succes
)

echo.
echo 💾 Etat de la BD:
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% -e "SELECT COUNT(*) as 'Utilisateurs' FROM novashop.users;"
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% -e "SELECT COUNT(*) as 'Produits' FROM novashop.products;"
"%MYSQL_PATH%" -u %DB_USER% -p%DB_PASS% -e "SELECT COUNT(*) as 'Catégories' FROM novashop.categories;"
echo.

echo ✅ Reset complet termine!
echo.
echo 🚀 Demarrage du serveur...
echo.
pause

cd /d "%~dp0\Public"
php -S localhost:8000 router.php
goto end

:invalid
echo.
echo ❌ Choix invalide
echo.
pause
goto end

:end
echo.
echo Au revoir!
echo.
pause
