@echo off
REM ==========================================
REM NovaShop Pro - Installation Automatique Complète
REM Script d'installation pour nouveau PC
REM ==========================================

chcp 65001 > nul
setlocal enabledelayedexpansion

cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║        🔧 NovaShop Pro - Installation Automatique 🔧           ║
echo ║     Détection + Téléchargement + Configuration complète        ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

REM Vérifier administrateur
net session >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERREUR] Ce script doit être exécuté en tant qu'administrateur!
    echo.
    echo Solution: Clic droit sur le fichier ^> Exécuter en tant qu'administrateur
    echo.
    pause
    exit /b 1
)

echo [INFO] Exécution en tant qu'administrateur... OK
echo.

REM ==========================================
REM Vérifier les dépendances existantes
REM ==========================================
echo [RECHERCHE] Vérification des dépendances...
echo.

set "FOUND_PHP=0"
set "FOUND_MYSQL=0"

where php.exe >nul 2>&1
if !errorlevel! equ 0 (
    echo [OK] PHP est déjà installé
    set "FOUND_PHP=1"
)

where mysql.exe >nul 2>&1
if !errorlevel! equ 0 (
    echo [OK] MySQL/MariaDB est déjà installé
    set "FOUND_MYSQL=1"
    goto check_if_all_found
)

for /d %%G in ("C:\Program Files\MariaDB*") do (
    if exist "%%G\bin\mysql.exe" (
        echo [OK] MariaDB trouvé: %%G
        set "FOUND_MYSQL=1"
        set "MYSQL_PATH=%%G"
        goto check_if_all_found
    )
)

:check_if_all_found
echo.

if "!FOUND_PHP!"=="1" if "!FOUND_MYSQL!"=="1" (
    echo [RÉSULTAT] ✅ Toutes les dépendances sont installées!
    echo.
    echo Vous pouvez maintenant:
    echo   1. Exécuter restart.bat pour commencer
    echo   2. Choisir l'option 1 (SETUP COMPLET)
    echo.
    pause
    exit /b 0
)

echo [INFOS] Dépendances manquantes:
if "!FOUND_PHP!"=="0" echo   • PHP 8.2 (à installer)
if "!FOUND_MYSQL!"=="0" echo   • MariaDB (à installer)
echo.

REM ==========================================
REM Menu d'installation
REM ==========================================
echo ╔════════════════════════════════════════════════════════════════╗
echo ║                  📦 Installation Requise 📦                    ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo [OPTIONS]
if "!FOUND_PHP!"=="0" echo   A. Installer PHP 8.2
if "!FOUND_MYSQL!"=="0" echo   B. Installer MariaDB
if "!FOUND_PHP!"=="1" if "!FOUND_MYSQL!"=="1" echo   C. Tout est prêt!
echo   Q. Quitter
echo.

set /p option="Choisissez (A/B/C/Q): "

if /i "%option%"=="A" goto install_php
if /i "%option%"=="B" goto install_mariadb
if /i "%option%"=="C" goto all_ready
if /i "%option%"=="Q" goto end

echo [ERREUR] Choix invalide
pause
goto check_if_all_found

REM ==========================================
REM Installation PHP
REM ==========================================
:install_php
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║                    💾 Installation PHP 8.2                     ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo [INFO] Téléchargement de PHP 8.2 (x64 Non Thread Safe)...
echo.
echo Étapes:
echo   1. Ouvrez: https://windows.php.net/download/
echo   2. Téléchargez: php-8.2.x-nts-Win32-x64.zip
echo   3. Créez le dossier: C:\php-8.2
echo   4. Extraire le ZIP dans C:\php-8.2
echo.
echo Une fois terminé, appuyez sur une touche...
echo.
pause

REM Vérifier si l'installation est complète
if exist "C:\php-8.2\php.exe" (
    echo [OK] PHP trouvé dans C:\php-8.2
    echo.
    echo [CONFIG] Ajout au PATH...
    setx PATH "C:\php-8.2;!PATH!" /M
    echo [OK] PATH mise à jour!
    set "FOUND_PHP=1"
) else (
    echo [ERREUR] PHP n'a pas été trouvé dans C:\php-8.2
    echo Assurez-vous d'avoir bien extrait les fichiers
    pause
    goto check_if_all_found
)

echo.
goto check_if_all_found

REM ==========================================
REM Installation MariaDB
REM ==========================================
:install_mariadb
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║                  💾 Installation MariaDB                       ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo [INFO] Téléchargement de MariaDB Community...
echo.
echo Étapes:
echo   1. Ouvrez: https://mariadb.org/download/
echo   2. Téléchargez: MariaDB 10.6+ (MSI installer)
echo   3. Exécutez l'installateur
echo.
echo [CONFIG] Recommandations d'installation:
echo   • Type: Typique / Standarde
echo   • Chemin: C:\Program Files\MariaDB x.x (par défaut OK)
echo   • Port: 3306
echo   • Utilisateur root: root
echo   • Mot de passe: root
echo   • Ajouter au PATH: OUI (important!)
echo.
echo Une fois l'installation terminée, appuyez sur une touche...
echo.
pause

REM Vérifier si l'installation est complète
for /d %%G in ("C:\Program Files\MariaDB*") do (
    if exist "%%G\bin\mysql.exe" (
        echo [OK] MariaDB trouvé: %%G
        echo.
        echo [CONFIG] Ajout au PATH...
        setx PATH "%%G\bin;!PATH!" /M
        echo [OK] PATH mise à jour!
        set "FOUND_MYSQL=1"
        set "MYSQL_PATH=%%G"
        goto check_mariadb_service
    )
)

echo [ERREUR] MariaDB n'a pas été trouvé
echo Assurez-vous d'avoir installé dans C:\Program Files\MariaDB
pause
goto check_if_all_found

:check_mariadb_service
echo.
echo [INFO] Vérification du service MariaDB...
sc query MariaDB >nul 2>&1
if !errorlevel! equ 0 (
    echo [OK] Service MariaDB est en cours d'exécution
) else (
    echo [INFO] Démarrage du service MariaDB...
    net start MariaDB >nul 2>&1
    if !errorlevel! equ 0 (
        echo [OK] Service MariaDB démarré
    )
)

echo.
goto check_if_all_found

REM ==========================================
REM Tout prêt
REM ==========================================
:all_ready
cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║          ✅ Installation Complète - Prêt à démarrer! ✅        ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo [RÉSUMÉ]
echo   ✓ PHP 8.2 installé
echo   ✓ MariaDB installé
echo   ✓ PATH configuré
echo.
echo [PROCHAINES ÉTAPES]
echo.
echo 1. Retournez au dossier NovaShop Pro
echo 2. Double-cliquez sur: restart.bat
echo 3. Choisissez l'option: 1 (SETUP COMPLET)
echo 4. Attendez la fin de l'installation (2-3 minutes)
echo 5. Accédez à: http://localhost:8000
echo.
echo [IDENTIFIANTS]
echo   Email: admin@novashop.local
echo   Mot de passe: admin123
echo.
pause
goto end

REM ==========================================
REM FIN
REM ==========================================
:end
echo.
echo À bientôt!
pause
exit /b 0
