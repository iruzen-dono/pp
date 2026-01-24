@echo off
REM Script ultra-simple pour tester
cls

echo [1] Demarrage
pause

chcp 65001 > nul
echo [2] Encodage OK
pause

setlocal enabledelayedexpansion
echo [3] Setlocal OK
pause

set "TEST=test"
echo [4] Variable = !TEST!
pause

REM Verifier PHP
if exist "C:\php-8.2\php.exe" (
    echo [5] PHP trouve
) else (
    echo [5] PHP non trouve
)
pause

REM Verifier MySQL
if exist "C:\Program Files\MariaDB\bin\mysql.exe" (
    echo [6] MySQL trouve
) else (
    echo [6] MySQL non trouve
)
pause

REM Demander input
echo [7] Va demander input...
set /p DB_USER="Nom d'utilisateur (defaut: root): "
echo [7.1] DB_USER = !DB_USER!
pause

echo [8] Script OK - fin
endlocal
exit /b 0
