@echo off
REM ==========================================
REM NovaShop Pro - Auto-Install PHP & MariaDB
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
echo ║    🌟 NovaShop Pro - Installation Automatique 🌟              ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

REM Admin check
net session >nul 2>&1
if errorlevel 1 (
    echo %ERROR% Admin requis!
    pause
    endlocal
    exit /b 1
)

REM Check PHP
if exist "C:\php-8.2\php.exe" (
    echo %SUCCESS% PHP trouvé
    set "PHP_OK=1"
) else (
    echo %WARN% PHP manquant - Installation automatique...
    set "PHP_OK=0"
)

REM Check MySQL
if exist "C:\Program Files\MariaDB\bin\mysql.exe" (
    echo %SUCCESS% MariaDB trouvé
    set "MYSQL_OK=1"
) else (
    echo %WARN% MariaDB manquant - Installation automatique...
    set "MYSQL_OK=0"
)

echo.

REM Install PHP if needed
if "!PHP_OK!"=="0" (
    call :install_php
    if errorlevel 1 (
        echo %ERROR% PHP installation failed
        pause
        endlocal
        exit /b 1
    )
)

REM Install MySQL if needed
if "!MYSQL_OK!"=="0" (
    call :install_mysql
    if errorlevel 1 (
        echo %ERROR% MySQL installation failed
        pause
        endlocal
        exit /b 1
    )
)

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
mysql -u !DB_USER! -p!DB_PASS! -e "DROP DATABASE novashop"
pause
goto menu

REM ==========================================
REM INSTALL PHP
REM ==========================================
:install_php
setlocal enabledelayedexpansion

echo %INFO% Installing PHP 8.2...

REM Create folder
if not exist "C:\php-8.2" mkdir "C:\php-8.2"

REM Download with PowerShell
echo %INFO% Downloading PHP... (this may take 1-2 minutes)

powershell -NoProfile -Command "try { Invoke-WebRequest -Uri 'https://windows.php.net/downloads/releases/php-8.2.21-nts-Win32-x64.zip' -OutFile 'C:\php-8.2.zip' -UseBasicParsing } catch { exit 1 }" 2>nul

if not exist "C:\php-8.2.zip" (
    echo %ERROR% Download failed - trying alternate URL
    powershell -NoProfile -Command "try { Invoke-WebRequest -Uri 'https://windows.php.net/downloads/releases/php-8.1.27-nts-Win32-x64.zip' -OutFile 'C:\php-8.2.zip' -UseBasicParsing } catch { exit 1 }" 2>nul
)

if not exist "C:\php-8.2.zip" (
    echo %ERROR% Download failed
    endlocal
    exit /b 1
)

echo %INFO% Extracting...
powershell -NoProfile -Command "Expand-Archive -Path 'C:\php-8.2.zip' -DestinationPath 'C:\php-8.2' -Force" 2>nul

if errorlevel 1 (
    echo %ERROR% Extract failed
    del "C:\php-8.2.zip"
    endlocal
    exit /b 1
)

del "C:\php-8.2.zip"

REM Add to PATH
echo %INFO% Adding to PATH...
setx PATH "%PATH%;C:\php-8.2"

echo %SUCCESS% PHP installed!
endlocal
exit /b 0

REM ==========================================
REM INSTALL MYSQL
REM ==========================================
:install_mysql
setlocal enabledelayedexpansion

echo %INFO% Installing MariaDB 10.5...

if not exist "C:\mariadb-install" mkdir "C:\mariadb-install"
cd /d "C:\mariadb-install"

echo %INFO% Downloading MariaDB... (this may take 2-3 minutes)

powershell -NoProfile -Command "try { Invoke-WebRequest -Uri 'https://downloads.mariadb.org/interstitial/mariadb-10.5.23/binaries/mariadb-10.5.23-winx64.zip' -OutFile 'mariadb.zip' -UseBasicParsing } catch { exit 1 }" 2>nul

if not exist "mariadb.zip" (
    echo %ERROR% Download failed
    cd /d "%~dp0"
    endlocal
    exit /b 1
)

echo %INFO% Extracting...
powershell -NoProfile -Command "Expand-Archive -Path 'mariadb.zip' -DestinationPath '.' -Force" 2>nul

REM Find extracted folder
for /d %%D in (mariadb-*) do (
    echo %INFO% Found: %%D
    if not exist "C:\Program Files\MariaDB" mkdir "C:\Program Files\MariaDB"
    xcopy "%%D\*" "C:\Program Files\MariaDB" /E /I /Y >nul
    if errorlevel 1 (
        echo %ERROR% Copy failed
        cd /d "%~dp0"
        endlocal
        exit /b 1
    )
)

REM Clean
cd /d "%~dp0"
rmdir /s /q "C:\mariadb-install" 2>nul

REM Add to PATH
echo %INFO% Adding to PATH...
setx PATH "%PATH%;C:\Program Files\MariaDB\bin"

echo %SUCCESS% MariaDB installed!
endlocal
exit /b 0

:end
echo Done!
endlocal
exit /b 0
