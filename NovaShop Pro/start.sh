#!/bin/bash
# ==========================================
# NovaShop Pro - Script de démarrage
# ==========================================

echo "🚀 Démarrage de NovaShop Pro..."
echo ""

# Vérifier PHP
if ! command -v php &> /dev/null; then
    echo "❌ PHP n'est pas installé. Veuillez installer PHP 8.0+"
    exit 1
fi

echo "✅ PHP détecté: $(php -v | head -n 1)"

# Vérifier MySQL
if ! command -v mysql &> /dev/null; then
    echo "⚠️  MySQL n'est pas trouvé dans le PATH"
    echo "   Veuillez démarrer MySQL manuellement si nécessaire"
fi

# Déployer la base de données (optionnel)
read -p "Voulez-vous initialiser la base de données? (o/N) " -n 1 -r
echo
if [[ $REPLY =~ ^[Oo]$ ]]; then
    echo "📊 Initialisation de la base de données..."
    mysql -u root < setup.sql
    if [ $? -eq 0 ]; then
        echo "✅ Base de données créée avec succès!"
    else
        echo "❌ Erreur lors de la création de la base de données"
    fi
fi

# Définir les permissions
echo "🔧 Configuration des permissions..."
chmod -R 755 Public/
chmod -R 755 App/Views/
mkdir -p Public/Assets/Uploads
chmod 777 Public/Assets/Uploads

echo "✅ Permissions configurées"

# Démarrer le serveur
echo ""
echo "🌐 Démarrage du serveur PHP..."
echo "   URL d'accès: http://localhost:8000"
echo "   Appuyez sur Ctrl+C pour arrêter le serveur"
echo ""

cd Public
php -S localhost:8000
