# NovaShop Pro

E-commerce platform built with PHP/MySQL - Modern MVC architecture with admin panel, product management, and order handling.

## 🚀 Quick Start

### Prerequisites
- PHP 7.4+
- MySQL 5.7+
- Composer

### Installation & Running

```bash
cd "NovaShop Pro"
composer install
php -S localhost:8000
```

✅ Server runs on `http://localhost:8000`

## 📁 Project Structure

```
pp/
├── README.md               # This file
├── docs/                  # Documentation
├── NovaShop Pro/          # Main application
└── archived_cleanup/      # Legacy files (archived)
```

## 🎯 Key Features

✅ **User Management**: Registration, login, email verification, password reset  
✅ **Product Catalog**: Browse products with variants, search & filter  
✅ **Shopping Cart**: Add/remove items, order management  
✅ **Admin Panel**: Manage users, products, orders, roles  
✅ **Order Tracking**: Order history and status updates  

## 🔐 Security

- **Password**: Bcrypt hashing (PASSWORD_BCRYPT)
- **Sessions**: Secure PHP sessions
- **CSRF Protection**: Token-based middleware
- **SQL Injection**: Parameterized PDO queries
- **XSS Protection**: HTML escaping on all output

## 📊 Database

Default test accounts (from seed data):
- User: `user@test.fr` / `password123`
- Admin: `admin@test.fr` / `admin123`

## 📚 Documentation

See `docs/` folder for:
- **SETUP.md** - Installation & configuration
- **TESTING.md** - Test scenarios
- **ADMIN.md** - Admin panel guide
- **VARIANTS.md** - Product variants

Legacy documentation archived in `archived_cleanup/`.

## 🛠️ Development

Quick scripts:
```bash
php "NovaShop Pro"/scripts/seed_complete_data.php  # Populate test data
```

## 📝 License

Internal project - NovaShop Pro 2026  
**Last updated:** February 5, 2026
