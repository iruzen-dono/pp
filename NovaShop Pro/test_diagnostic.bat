@echo off
REM ==========================================
REM Script de diagnostic - Trace chaque étape
REM ==========================================

echo [ETAPE 1] Démarrage du script
pause

chcp 65001 > nul
echo [ETAPE 2] Encodage UTF-8 changé

setlocal enabledelayedexpansion
echo [ETAPE 3] Delayed expansion activé

REM Test basique
set "TEST=valeur"
echo [ETAPE 4] Variable TEST = !TEST!
pause

REM Vérification admin
net session >nul 2>&1
if %errorlevel% neq 0 (
    echo [ETAPE 5] ERREUR: Non administrateur
    pause
    exit /b 1
)
echo [ETAPE 5] Admin vérifié - OK

REM Test where command
echo [ETAPE 6] Test commande WHERE...
where php.exe >nul 2>&1
echo [ETAPE 6.1] WHERE errorlevel = %errorlevel%
pause

REM Test errorlevel avec delayed expansion
where php.exe >nul 2>&1
if !errorlevel! equ 0 (
    echo [ETAPE 7] PHP trouvé
) else (
    echo [ETAPE 7] PHP non trouvé
)
pause

echo [ETAPE 8] Test réussi - Script se termine correctement
pause
endlocal
exit /b 0
