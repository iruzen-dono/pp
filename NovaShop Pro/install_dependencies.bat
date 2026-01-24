@echo off
REM ==========================================
REM NovaShop Pro - Installation des Dépendances
REM ==========================================
REM Ce script installe automatiquement:
REM  • PHP 8.2
REM  • MariaDB (avec MySQL client)
REM  • Ajoute les chemins au PATH
REM ==========================================

chcp 65001 > nul
setlocal enabledelayedexpansion

cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║        📦 Installation des Dépendances NovaShop Pro 📦         ║
echo ║    PHP + MariaDB + Configuration automatique du PATH           ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

REM Vérifier les privilèges administrateur
net session >nul 2>&1
if %errorlevel% neq 0 (
    echo [ERREUR] Ce script doit être exécuté en tant qu'administrateur!
    echo.
    echo Clic droit sur le fichier et choisissez "Exécuter en tant qu'administrateur"
    echo.
    pause
    exit /b 1
)

echo [INFO] Vérification des dépendances actuelles...
echo.

REM Vérifier PHP
where php.exe >nul 2>&1
if !errorlevel! equ 0 (
    for /f "delims=" %%i in ('php -v') do (
        echo [OK] PHP trouvé: %%i
        set "FOUND_PHP=1"
        goto check_mysql
    )
)

:check_mysql
REM Vérifier MySQL/MariaDB
where mysql.exe >nul 2>&1
if !errorlevel! equ 0 (
    echo [OK] MySQL/MariaDB trouvé!
    set "FOUND_MYSQL=1"
    goto check_complete
)

for /d %%G in ("C:\Program Files\MariaDB*") do (
    if exist "%%G\bin\mysql.exe" (
        echo [OK] MariaDB trouvé: %%G
        set "FOUND_MYSQL=1"
        set "MYSQL_PATH=%%G"
        goto check_complete
    )
)

:check_complete
if defined FOUND_PHP if defined FOUND_MYSQL (
    echo.
    echo [OK] Toutes les dépendances sont déjà installées!
    echo.
    pause
    exit /b 0
)

echo.
echo [INFO] Certaines dépendances manquent. Installation en cours...
echo.

REM ==========================================
REM Installation PHP
REM ==========================================
if not defined FOUND_PHP (
    echo [TÉLÉCHARGEMENT] PHP 8.2...
    echo.
    echo Veuillez télécharger PHP 8.2 (x64 Non Thread Safe):
    echo   https://www.php.net/downloads
    echo.
    echo Ou visitez: https://windows.php.net/download/
    echo   • Téléchargez: php-8.2.x-nts-Win32-x64.zip
    echo   • Extraire dans: C:\php-8.2
    echo.
    echo Une fois téléchargé et extrait, continuez...
    echo.
    pause
    
    REM Vérifier si PHP est maintenant installé
    where php.exe >nul 2>&1
    if !errorlevel! neq 0 (
        echo [SETUP PATH] Configuration du PATH pour PHP...
        setx PATH "C:\php-8.2;!PATH!" /M
        
        REM Recharger les variables d'environnement
        for /f "tokens=*" %%i in ('reg query "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v PATH ^| find /i "Path"') do set "newPath=%%i"
        
        set "PATH=C:\php-8.2;!newPath:~15!"
        
        echo [OK] PATH mis à jour!
    )
)

REM ==========================================
REM Installation MariaDB
REM ==========================================
if not defined FOUND_MYSQL (
    echo.
    echo [TÉLÉCHARGEMENT] MariaDB...
    echo.
    echo Veuillez télécharger MariaDB Community Edition:
    echo   https://mariadb.org/download/
    echo.
    echo Recommandations d'installation:
    echo   • Version: MariaDB 10.6 ou plus récente
    echo   • Type d'installation: Typique
    echo   • Chemin standard: C:\Program Files\MariaDB x.x
    echo   • Port: 3306 (par défaut)
    echo   • Utilisateur: root / Mot de passe: root
    echo.
    echo Une fois installé, continuez...
    echo.
    pause
    
    REM Chercher MariaDB après installation
    for /d %%G in ("C:\Program Files\MariaDB*") do (
        if exist "%%G\bin\mysql.exe" (
            echo [SETUP PATH] Configuration du PATH pour MariaDB...
            setx PATH "%%G\bin;!PATH!" /M
            echo [OK] PATH mis à jour!
            goto post_install
        )
    )
    
    echo [ERREUR] MariaDB non trouvé après installation
    echo Assurez-vous d'avoir installé dans C:\Program Files\MariaDB
    pause
    exit /b 1
)

:post_install
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║              ✅ Installation Terminée !                        ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.
echo [INFO] Vérification finale...
echo.

REM Recharger PATH depuis le registre
for /f "tokens=2*" %%A in ('reg query "HKLM\SYSTEM\CurrentControlSet\Control\Session Manager\Environment" /v PATH ^| find /i "PATH"') do set "newPath=%%B"
set "PATH=!newPath!"

REM Vérifier PHP
php -v >nul 2>&1
if !errorlevel! equ 0 (
    echo [OK] PHP fonctionne correctement!
) else (
    echo [ERREUR] PHP non trouvé dans le PATH
    echo Veuillez redémarrer l'invite de commandes et réessayer
)

REM Vérifier MySQL
mysql --version >nul 2>&1
if !errorlevel! equ 0 (
    echo [OK] MySQL fonctionne correctement!
) else (
    echo [ERREUR] MySQL non trouvé dans le PATH
    echo Veuillez redémarrer l'invite de commandes et réessayer
)

echo.
echo [INFO] Les variables d'environnement ont été modifiées!
echo Redémarrez ce script ou l'invite de commandes pour terminer.
echo.
pause
exit /b 0
