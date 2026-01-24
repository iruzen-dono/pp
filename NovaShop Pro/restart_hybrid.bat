@echo off
REM ==========================================
REM NovaShop Pro - Hybrid Install (Manual + Auto)
REM ==========================================

cls
chcp 65001 > nul
setlocal enabledelayedexpansion

set "SUCCESS=[OK]"
set "ERROR=[ERREUR]"
set "INFO=[INFO]"
set "WARN=[ATTENTION]"

cls
echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║   🌟 NovaShop Pro - Installation Hybride 🌟                   ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

REM Admin check
net session >nul 2>&1
if errorlevel 1 (
    echo %ERROR% Admin required!
    pause
    endlocal
    exit /b 1
)

echo %SUCCESS% Admin rights OK
echo.

REM Check PHP
if exist "C:\php-8.2\php.exe" (
    echo %SUCCESS% PHP trouvé
    set "PHP_OK=1"
) else (
    echo %WARN% PHP manquant
    set "PHP_OK=0"
)

REM Check MySQL
if exist "C:\Program Files\MariaDB\bin\mysql.exe" (
    echo %SUCCESS% MariaDB trouvé
    set "MYSQL_OK=1"
) else (
    echo %WARN% MariaDB manquant
    set "MYSQL_OK=0"
)

echo.

REM Install PHP if needed
if "!PHP_OK!"=="0" (
    call :install_php_hybrid
    if errorlevel 1 (
        echo %ERROR% PHP installation failed
        pause
        endlocal
        exit /b 1
    )
)

REM Install MySQL if needed
if "!MYSQL_OK!"=="0" (
    call :install_mysql_hybrid
    if errorlevel 1 (
        echo %ERROR% MySQL installation failed
        pause
        endlocal
        exit /b 1
    )
)

echo %SUCCESS% Installation complete!
echo.

REM Ask credentials
echo %INFO% Identifiants MySQL
set /p DB_USER="User (defaut: root): "
if "!DB_USER!"=="" set "DB_USER=root"
set /p DB_PASS="Pass (defaut: vide): "

echo.
echo %SUCCESS% Configuration complete!
pause

REM Menu
:menu
cls
echo.
echo 1=Setup  2=Restart  3=Reset  4=Images  5=Cache  6=Full
set /p CHOICE="Choice (1-6): "

if "!CHOICE!"=="1" goto setup
if "!CHOICE!"=="2" goto restart
if "!CHOICE!"=="3" goto reset
if "!CHOICE!"=="4" goto images
if "!CHOICE!"=="5" goto cache
if "!CHOICE!"=="6" goto fullreset

goto menu

:setup
echo Setup...
pause
goto menu

:restart
echo Starting server on localhost:8000
cd /d "%~dp0Public"
php -S localhost:8000
goto menu

:reset
echo Resetting DB...
mysql -u !DB_USER! -p!DB_PASS! -e "DROP DATABASE IF EXISTS novashop"
mysql -u !DB_USER! -p!DB_PASS! -e "CREATE DATABASE novashop CHARACTER SET utf8mb4"
mysql -u !DB_USER! -p!DB_PASS! novashop < "%~dp0setup.sql"
mysql -u !DB_USER! -p!DB_PASS! novashop < "%~dp0seed_premium.sql"
pause
goto menu

:images
echo Downloading images...
php "%~dp0scripts\download_product_images.php"
pause
goto menu

:cache
echo Clear browser cache - Instructions shown
pause
goto menu

:fullreset
echo Full reset...
mysql -u !DB_USER! -p!DB_PASS! -e "DROP DATABASE IF EXISTS novashop"
pause
goto menu

REM ==========================================
REM INSTALL PHP - Hybrid (Auto + Manual)
REM ==========================================
:install_php_hybrid
setlocal enabledelayedexpansion

echo %INFO% Installation de PHP 8.2...
echo.

if not exist "C:\php-8.2" mkdir "C:\php-8.2"

echo %INFO% Tentative 1: Téléchargement automatique...
certutil -urlcache -split -f "https://windows.php.net/downloads/releases/php-8.2.21-nts-Win32-x64.zip" "C:\php-8.2.zip" >nul 2>&1

if exist "C:\php-8.2.zip" (
    echo %SUCCESS% Téléchargement réussi
    goto extract_php
)

echo %WARN% Téléchargement échoué - Mode manuel requis
echo.
echo %INFO% Téléchargement manuel de PHP:
echo  1. Ouvrez: https://windows.php.net/download/
echo  2. Téléchargez: php-8.2-nts-Win32-x64.zip
echo  3. Placez le fichier: C:\php-8.2.zip
echo  4. Appuyez sur une touche pour continuer...
pause

if not exist "C:\php-8.2.zip" (
    echo %ERROR% Fichier non trouvé!
    endlocal
    exit /b 1
)

:extract_php
echo %INFO% Extraction...

REM Try tar first
tar -xf "C:\php-8.2.zip" -C "C:\php-8.2" >nul 2>&1

if errorlevel 1 (
    REM Try PowerShell
    powershell -NoProfile -Command "Expand-Archive -Path 'C:\php-8.2.zip' -DestinationPath 'C:\php-8.2' -Force" >nul 2>&1
)

if errorlevel 1 (
    echo %ERROR% Extraction failed!
    del "C:\php-8.2.zip"
    endlocal
    exit /b 1
)

del "C:\php-8.2.zip"

echo %INFO% Adding to PATH...
setx PATH "%PATH%;C:\php-8.2" >nul 2>&1

echo %SUCCESS% PHP installed!
endlocal
exit /b 0

REM ==========================================
REM INSTALL MYSQL - Hybrid (Auto + Manual)
REM ==========================================
:install_mysql_hybrid
setlocal enabledelayedexpansion

echo %INFO% Installation de MariaDB 10.5...
echo.

if not exist "C:\mariadb-install" mkdir "C:\mariadb-install"
cd /d "C:\mariadb-install"

echo %INFO% Tentative 1: Téléchargement automatique...
certutil -urlcache -split -f "https://downloads.mariadb.org/interstitial/mariadb-10.5.23/binaries/mariadb-10.5.23-winx64.zip" "mariadb.zip" >nul 2>&1

if exist "mariadb.zip" (
    echo %SUCCESS% Téléchargement réussi
    goto extract_mysql
)

echo %WARN% Téléchargement échoué - Mode manuel requis
echo.
echo %INFO% Téléchargement manuel de MariaDB:
echo  1. Ouvrez: https://mariadb.org/download/
echo  2. Téléchargez: mariadb-10.5-winx64.zip
echo  3. Placez le fichier: C:\mariadb-install\mariadb.zip
echo  4. Appuyez sur une touche pour continuer...
pause

if not exist "mariadb.zip" (
    echo %ERROR% Fichier non trouvé!
    cd /d "%~dp0"
    endlocal
    exit /b 1
)

:extract_mysql
echo %INFO% Extraction...

REM Try tar first
tar -xf "mariadb.zip" -C "." >nul 2>&1

if errorlevel 1 (
    REM Try PowerShell
    powershell -NoProfile -Command "Expand-Archive -Path 'mariadb.zip' -DestinationPath '.' -Force" >nul 2>&1
)

if errorlevel 1 (
    echo %ERROR% Extraction failed!
    cd /d "%~dp0"
    endlocal
    exit /b 1
)

REM Find extracted folder and copy
for /d %%D in (mariadb-*) do (
    if not exist "C:\Program Files\MariaDB" mkdir "C:\Program Files\MariaDB"
    xcopy "%%D\*" "C:\Program Files\MariaDB" /E /I /Y >nul 2>&1
)

cd /d "%~dp0"
rmdir /s /q "C:\mariadb-install" >nul 2>&1

echo %INFO% Adding to PATH...
setx PATH "%PATH%;C:\Program Files\MariaDB\bin" >nul 2>&1

echo %SUCCESS% MariaDB installed!
endlocal
exit /b 0

:end
echo Done!
endlocal
exit /b 0
