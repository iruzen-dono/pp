@echo off
REM ==========================================
REM NovaShop Pro - Version SIMPLIFIEE et STABLE
REM ==========================================

echo [START] Script commence...
pause

chcp 65001 > nul
setlocal enabledelayedexpansion

echo [1] Admin check...
net session >nul 2>&1
if errorlevel 1 (
    echo [ERROR] Besoin droits admin!
    pause
    endlocal
    exit /b 1
)
echo [1] OK - Admin detecte

echo [2] Verification PHP...
if exist "C:\php-8.2\php.exe" (
    echo [2] OK - PHP trouve
    set "PHP_INSTALLED=1"
) else (
    echo [2] INFO - PHP non trouve
    set "PHP_INSTALLED=0"
)

echo [3] Verification MySQL...
if exist "C:\Program Files\MariaDB\bin\mysql.exe" (
    echo [3] OK - MySQL trouve  
    set "MYSQL_INSTALLED=1"
) else (
    echo [3] INFO - MySQL non trouve
    set "MYSQL_INSTALLED=0"
)

echo [4] Demande credentials...
set /p DB_USER="User (defaut: root): "
if "!DB_USER!"=="" set "DB_USER=root"
echo [4] User: !DB_USER!

echo [5] Demande password...
set /p DB_PASS="Pass (defaut: vide): "
echo [5] Password configure

echo [6] Menu...
echo  1=Setup  2=Restart  3=Reset  4=Images  5=Cache  6=Full
set /p CHOICE="Choix (1-6): "
echo [6] Choix: !CHOICE!

if "!CHOICE!"=="1" (
    echo [6.1] Setup complet...
    echo TODO: implementer setup
) else if "!CHOICE!"=="2" (
    echo [6.2] Restart serveur...
    echo TODO: implementer restart
) else (
    echo [6.X] Option non implementee
)

echo [END] Script termine correctement
endlocal
exit /b 0
