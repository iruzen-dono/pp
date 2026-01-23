@echo off
REM ==========================================
REM NovaShop Pro - Clean Restart Script
REM Après les fixes appliqués
REM ==========================================

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

REM Vérifier que MySQL est lancé
mysql -u root -p0000 -e "SELECT 1" >nul 2>&1
if errorlevel 1 (
    echo ❌ Erreur: MySQL n'est pas accessible
    echo Assurez-vous que MySQL est lancé!
    pause
    goto end
)

REM Supprimer et recréer la BD
mysql -u root -p0000 -e "DROP DATABASE IF EXISTS novashop;" >nul 2>&1
echo ✅ Ancienne BD supprimée

REM Recréer la BD avec données
mysql -u root -p0000 < setup.sql
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
mysql -u root -p0000 -e "DROP DATABASE IF EXISTS novashop;" >nul 2>&1
echo ✅ BD supprimee

REM Recréer BD
mysql -u root -p0000 < setup.sql
if errorlevel 1 (
    echo ❌ Erreur lors de la creation de la BD
    pause
    goto end
) else (
    echo ✅ BD creee avec succes
)

echo.
echo 💾 Etat de la BD:
mysql -u root -p0000 -e "SELECT COUNT(*) as 'Utilisateurs' FROM novashop.users;"
mysql -u root -p0000 -e "SELECT COUNT(*) as 'Produits' FROM novashop.products;"
mysql -u root -p0000 -e "SELECT COUNT(*) as 'Catégories' FROM novashop.categories;"
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
