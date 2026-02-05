@echo off
REM Démarrage simple du serveur NovaShop Pro
REM Pas de vérifications, juste lance le serveur
REM À utiliser si les autres fichiers ne marchent pas

php -S localhost:8000 -t Public Public/router.php
pause
