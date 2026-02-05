# Setup & Installation

## Prerequisites

- **PHP 7.4+** with PDO MySQL extension
- **MySQL 5.7+** (or MariaDB 10.3+)
- **Composer** (for dependency management)
- **Windows/Linux/macOS** shell

## Quick Start (5 minutes)

### 1. Database Setup

```bash
mysql -u root -p0000 -e "CREATE DATABASE IF NOT EXISTS novashop;"
mysql -u root -p0000 novashop < "NovaShop Pro/setup.sql"
```

Available test accounts:
- User: `user@test.fr` / `password123`
- Admin: `admin@test.fr` / `admin123`

### 2. Install Dependencies

```bash
cd "NovaShop Pro"
composer install
```

### 3. Start Development Server

```bash
php -S localhost:8000
```

**✅ Application ready at:** `http://localhost:8000`

---

## Detailed Configuration

### Database Connection

Database connection is centralized in:
- **App/Config/Database.php**

Default credentials (can be modified there):
```
Host: localhost
User: root
Password: 0000
Database: novashop
```

### Environment

No `.env` file needed - database.php contains hardcoded connection for development.

For production, modify `Database.php` to use environment variables.

### File Permissions

Ensure write access to:
- `Public/Assets/Images/products/` - Product image storage
- `Public/Assets/` - Generated CSS/JS cache (if applicable)

---

## Populating Test Data

Quick seeding with products, orders, and users:

```bash
php scripts/seed_complete_data.php
```

This will generate:
- 34 test products across 4 categories
- 4 sample orders
- 2 test users (+ admin)
- Product images from picsum.photos

---

## Troubleshooting

### Common Issues

**"Connection refused"** - MySQL not running
```bash
# Start MySQL (Windows)
net start MySQL80
```

**"Class not found"**
```bash
cd "NovaShop Pro"
composer dump-autoload
```

**"Permission denied" on images**
```bash
chmod -R 755 Public/Assets/Images/products/
```

See `TROUBLESHOOTING.md` for more issues.

---

**Last updated:** February 5, 2026
