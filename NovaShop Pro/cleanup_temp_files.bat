@echo off
REM Script de nettoyage des fichiers temporaires
REM À exécuter une seule fois après le développement

echo.
echo ╔════════════════════════════════════════════════════════════════╗
echo ║          🧹 Nettoyage des Fichiers Temporaires                ║
echo ╚════════════════════════════════════════════════════════════════╝
echo.

echo %INFO% Fichiers à supprimer:
echo    - check_images.php
echo    - cleanup_images.php
echo    - clean_reset_db.php
echo    - deployment_checklist.php
echo    - download_missing_images.php
echo    - download_proper_images.php
echo    - download_realistic_images.php
echo    - fallback_images.php
echo    - fetch_images.php
echo    - fix_images.php
echo    - generate_product_images.php
echo    - generate_realistic_images.php
echo    - import_premium_data.bat
echo    - import_premium_data.sh
echo    - verify_import.php
echo    - verify_local_images.php
echo    - DEPLOYMENT_VERIFICATION.md
echo.

set /p confirm="Confirmez la suppression? (O/N): "
if /i not "%confirm%"=="O" (
    echo Annulé
    pause
    exit /b 0
)

echo.
echo Suppression en cours...

REM Supprimer les fichiers PHP temporaires
del /q check_images.php 2>nul
del /q cleanup_images.php 2>nul
del /q clean_reset_db.php 2>nul
del /q deployment_checklist.php 2>nul
del /q download_missing_images.php 2>nul
del /q download_proper_images.php 2>nul
del /q download_realistic_images.php 2>nul
del /q fallback_images.php 2>nul
del /q fetch_images.php 2>nul
del /q fix_images.php 2>nul
del /q generate_product_images.php 2>nul
del /q generate_realistic_images.php 2>nul
del /q verify_import.php 2>nul
del /q verify_local_images.php 2>nul

REM Supprimer les fichiers de déploiement
del /q import_premium_data.bat 2>nul
del /q import_premium_data.sh 2>nul
del /q DEPLOYMENT_VERIFICATION.md 2>nul

REM Supprimer le dossier Delete s'il existe
if exist Delete (
    rmdir /s /q Delete 2>nul
)

echo.
echo ✅ Nettoyage terminé!
echo.
pause
