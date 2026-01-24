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

REM ADMIN CHECK
net session >nul 2>&1
if errorlevel 1 (
    echo %ERROR% Admin required!
    pause
    endlocal
    exit /b 1
)

echo %SUCCESS% Admin OK
echo.

REM VERIFY PHP
echo %INFO% Verification PHP...
if exist "C:\php-8.2\php.exe" (
    echo %SUCCESS% PHP found
    set "PHP_OK=1"
) else (
    echo %ERROR% PHP missing
    set "PHP_OK=0"
)

REM VERIFY MYSQL
echo %INFO% Verification MariaDB...
if exist "C:\Program Files\MariaDB\bin\mysql.exe" (
    echo %SUCCESS% MariaDB found
    set "MYSQL_OK=1"
) else (
    echo %ERROR% MariaDB missing
    set "MYSQL_OK=0"
)

echo.

REM IF MISSING - SHOW INSTRUCTIONS AND EXIT
if "!PHP_OK!"=="0" goto missing_tools
if "!MYSQL_OK!"=="0" goto missing_tools

REM ALL OK - CONTINUE
echo %SUCCESS% All tools detected!
echo.
goto ask_credentials

:missing_tools
echo %ERROR% Installation required!
echo.

if "!PHP_OK!"=="0" (
    echo INSTALL PHP 8.2:
    echo  1. Download: https://windows.php.net/download/
    echo  2. Choose: php-8.2-nts-Win32-x64.zip
    echo  3. Create: C:\php-8.2
    echo  4. Extract ZIP into it
    echo.
)

if "!MYSQL_OK!"=="0" (
    echo INSTALL MARIADB:
    echo  1. Download: https://mariadb.org/download/
    echo  2. Install: MariaDB 10.5+ MSI
    echo  3. Path: C:\Program Files\MariaDB
    echo.
)

echo Once installed, run this script again.
echo.
pause
endlocal
exit /b 1

:ask_credentials
echo %INFO% MySQL credentials
echo.
set /p DB_USER="User (default: root): "
if "!DB_USER!"=="" set "DB_USER=root"
set /p DB_PASS="Password (default: empty): "

echo.
echo %SUCCESS% Configuration OK
echo.

REM MENU
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
cls
echo Setup...
mysql -u !DB_USER! -p!DB_PASS! -e "DROP DATABASE IF EXISTS novashop"
mysql -u !DB_USER! -p!DB_PASS! -e "CREATE DATABASE novashop CHARACTER SET utf8mb4"
mysql -u !DB_USER! -p!DB_PASS! novashop < "%~dp0setup.sql"
mysql -u !DB_USER! -p!DB_PASS! novashop < "%~dp0seed_premium.sql"
echo %SUCCESS% Setup OK
pause
goto menu

:restart
cls
echo Starting server on localhost:8000
cd /d "%~dp0Public"
php -S localhost:8000
goto menu

:reset
cls
echo Reset BD...
mysql -u !DB_USER! -p!DB_PASS! -e "DROP DATABASE IF EXISTS novashop"
mysql -u !DB_USER! -p!DB_PASS! -e "CREATE DATABASE novashop CHARACTER SET utf8mb4"
mysql -u !DB_USER! -p!DB_PASS! novashop < "%~dp0setup.sql"
mysql -u !DB_USER! -p!DB_PASS! novashop < "%~dp0seed_premium.sql"
echo %SUCCESS% BD reset OK
pause
goto menu

:images
cls
echo Downloading images...
php "%~dp0scripts\download_product_images.php"
echo %SUCCESS% Done
pause
goto menu

:cache
cls
echo Clear browser cache:
echo FIREFOX: Ctrl+H ^> Delete
echo CHROME: Ctrl+Shift+Delete
echo EDGE: Ctrl+Shift+Delete
pause
goto menu

:fullreset
cls
echo DELETE EVERYTHING?
set /p CONFIRM="Confirm (O/N): "
if /i "!CONFIRM!"=="O" (
    mysql -u !DB_USER! -p!DB_PASS! -e "DROP DATABASE IF EXISTS novashop"
    echo %SUCCESS% Deleted
) else (
    echo Cancelled
)
pause
goto menu

endlocal
exit /b 0
