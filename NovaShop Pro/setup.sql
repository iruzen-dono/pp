-- ==========================================
-- NovaShop Pro - Script de configuration BDD
-- ==========================================
-- Exécuter ce script pour initialiser la base de données

-- Créer la base de données
CREATE DATABASE IF NOT EXISTS novashop CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE novashop;

-- ==========================================
-- TABLE: Utilisateurs
-- ==========================================
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('user', 'admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: Catégories
-- ==========================================
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: Produits
-- ==========================================
CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    image_url VARCHAR(500),
    price DECIMAL(10, 2) NOT NULL,
    category_id INT,
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_category (category_id),
    FULLTEXT INDEX ft_search (name, description)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: Commandes
-- ==========================================
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10, 2) DEFAULT 0,
    status ENUM('pending', 'confirmed', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user (user_id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- TABLE: Articles de commande
-- ==========================================
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL CHECK (quantity > 0),
    price DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT,
    INDEX idx_order (order_id),
    INDEX idx_product (product_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ==========================================
-- DONNÉES DE TEST
-- ==========================================

-- Insérer des utilisateurs admin et test
INSERT INTO users (name, email, password, role) VALUES
('Admin NovaShop', 'admin@novashop.local', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcg7b3XeKeUxWdeS86E36P4/LaC', 'admin'),
('Client Test', 'user@novashop.local', '$2y$10$V8VbVIo0IqHXaMp8rVJI/OjpPH7W7LV7/YDJ4EpHWBaQX3L1dCIKi', 'user');

-- Insérer des catégories
INSERT INTO categories (name, description) VALUES
('Électronique', 'Appareils et accessoires électroniques'),
('Vêtements', 'Articles de mode et vêtements'),
('Livres', 'Littérature et éducation'),
('Maison', 'Articles pour la maison et décoration');

-- Insérer des produits
INSERT INTO products (name, description, price, category_id, stock) VALUES
('Laptop Pro 15"', 'Ordinateur portable haut de gamme avec processeur dernière génération', 1299.99, 1, 15),
('Souris Wireless', 'Souris sans fil ergonomique', 29.99, 1, 50),
('T-Shirt NovaShop', 'T-shirt collection exclusive NovaShop', 19.99, 2, 100),
('Jeans Premium', 'Jeans confortable et durable', 79.99, 2, 40),
('Guide PHP Moderne', 'Apprendre PHP 8+ avec exemple pratiques', 39.99, 3, 25),
('Lampe LED', 'Lampe LED économe en énergie', 49.99, 4, 30);

-- Insérer un utilisateur de test
INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@novashop.local', '$2y$10$abc123...', 'admin'),
('User Test', 'user@novashop.local', '$2y$10$xyz789...', 'user');

-- ==========================================
-- VÉRIFICATION
-- ==========================================
SELECT COUNT(*) AS total_users FROM users;
SELECT COUNT(*) AS total_products FROM products;
SELECT COUNT(*) AS total_categories FROM categories;

-- ==========================================
-- Note: Les mots de passe de test doivent être générés avec password_hash()
-- Exemple en PHP:
-- password_hash('password123', PASSWORD_BCRYPT);
-- ==========================================
