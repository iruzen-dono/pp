# Troubleshooting Guide

## Common Issues & Solutions

### 1. Server Won't Start

**Error:** `Address already in use` or `port 8000 in use`

**Solution:**
```bash
# Kill process using port 8000
netstat -ano | findstr :8000      # Windows - find PID
taskkill /PID [PID_NUMBER] /F     # Kill it

# Or use different port
php -S localhost:8001
```

---

### 2. Database Connection Error

**Error:** `SQLSTATE[HY000]: General error: 2002 Cannot assign requested address`

**Solution:**
```bash
# Verify MySQL is running
mysql -u root -p0000 -e "SELECT 1;"

# Windows - start MySQL service
net start MySQL80

# Or check credentials in App/Config/Database.php
```

---

### 3. Images Not Displaying

**Symptom:** Products show placeholder/blank boxes

**Possible causes:**

#### A. File doesn't exist
```bash
# Check if images folder exists
ls "NovaShop Pro"/Public/Assets/Images/products/

# If empty, run seed script
php "NovaShop Pro"/scripts/seed_complete_data.php
```

#### B. Wrong permission
```bash
chmod -R 755 "NovaShop Pro"/Public/Assets/Images/
```

#### C. Wrong image path in database
```sql
-- Check database images
SELECT id, name, image_url FROM products LIMIT 5;

-- Should show paths like: /Assets/Images/products/product_1_1.jpg
-- Not: https://... (unless intentional)
```

#### D. Fix broken images
```bash
php "NovaShop Pro"/scripts/fix_product_images.php
```

---

### 4. "Class not found" Error

**Error:** `Class 'App\Models\Product' not found`

**Solution:**
```bash
cd "NovaShop Pro"
composer dump-autoload
php -S localhost:8000
```

---

### 5. Login Not Working

**Error:** `Incorrect credentials` even with correct password

**Possible causes:**

#### A. User doesn't exist
```sql
SELECT COUNT(*) FROM users WHERE email='admin@test.fr';
```

#### B. Password hash issue
```sql
-- Verify password is hashed
SELECT password FROM users WHERE email='admin@test.fr';

-- Should look like: $2y$10$... (bcrypt hash)
-- Not: plain text password
```

#### C. Session issue
- Clear browser cookies
- Try private/incognito window
- Check PHP session directory is writable

---

### 6. CSRF Token Error

**Error:** `CSRF Token Mismatch` or `Invalid Token`

**Causes:**
- Token expired (> 25 minutes)
- Form opened from different domain
- JavaScript disabled (rare)

**Solution:**
1. Refresh page
2. If using localStorage/cookies, clear them
3. Try again with fresh form

---

### 7. Products Not Showing

**Symptom:** Products page blank or shows "No products"

**Solution:**
```bash
# Check database
mysql -u root -p0000 -e "SELECT COUNT(*) FROM novashop.products;"

# If 0, seed data
php "NovaShop Pro"/scripts/seed_complete_data.php

# If still blank, check categories
SELECT COUNT(*) FROM categories;
```

---

### 8. Email Verification Not Working

**Issue:** Password reset tokens not being used

**Check:**
```sql
-- Verify table exists
DESCRIBE email_verification_tokens;

-- Check tokens created
SELECT COUNT(*) FROM email_verification_tokens;
```

**Fix:**
```bash
# Re-run seed script to create table if missing
php "NovaShop Pro"/scripts/seed_complete_data.php
```

---

### 9. Cart Not Persisting

**Issue:** Items disappear after refresh or logout

**Cause:** Sessions not configured properly

**Solution:**
1. Check PHP session directory exists
2. Verify sessions enabled in php.ini
3. Check cookies enabled in browser

**Verify:**
```php
// In any view
echo session_id(); // Should show long string
```

---

### 10. Admin Panel Access Denied

**Error:** Redirects to login or shows 403 Forbidden

**Check:**
```sql
-- Verify user is admin
SELECT email, role FROM users WHERE email='admin@test.fr';

-- Should return 'admin' or 'super_admin'
```

**Solution:**
```sql
-- If role is 'user', update it
UPDATE users SET role='admin' WHERE email='admin@test.fr';
```

---

### 11. "404 Not Found" on Routes

**Issue:** Pages like `/admin` or `/products` show 404

**Check:**
1. Server still running? (should see "Listening on http://localhost:8000")
2. URL correct? (`http://localhost:8000/admin`, not `localhost/admin`)
3. Check router.php exists and is correct

---

### 12. Composer Issues

#### "Autoloader not found"
```bash
cd "NovaShop Pro"
composer install
composer dump-autoload
```

#### "Package not found"
```bash
composer update
```

---

## Debug Mode

### Enable Error Display
```php
// In Public/index.php, add at top:
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
```

### Check PHP Logs
```bash
# Windows
Get-Content $env:APPDATA\PHP\php_errors.log -Tail 20

# Linux
tail -20 /var/log/php-fpm.log
```

### Database Debug
```bash
# Check active connections
mysql -u root -p0000 -e "SHOW PROCESSLIST;"

# Kill hung connection
KILL [connection_id];
```

---

## Performance Issues

### Slow page load

1. Check database queries:
   ```sql
   SET SESSION sql_mode='';
   SELECT * FROM products ORDER BY id DESC LIMIT 10;
   ```

2. Check image sizes:
   ```bash
   ls -lh "NovaShop Pro"/Public/Assets/Images/products/ | head
   # Images > 100KB each indicates compression needed
   ```

3. Optimize images:
   ```bash
   php "NovaShop Pro"/scripts/fix_product_images.php
   ```

---

## Backup & Recovery

### Backup database
```bash
mysqldump -u root -p0000 novashop > novashop_backup.sql
```

### Restore database
```bash
mysql -u root -p0000 novashop < novashop_backup.sql
```

### Reset completely
```bash
mysql -u root -p0000 -e "DROP DATABASE novashop;"
mysql -u root -p0000 novashop < "NovaShop Pro/setup.sql"
php "NovaShop Pro"/scripts/seed_complete_data.php
```

---

## Still stuck?

1. Check browser console (F12) for JavaScript errors
2. Check network tab for failed requests
3. Review error logs in terminal
4. Check database directly for data integrity
5. Try fresh database reset (see Backup & Recovery)

---

**Last updated:** February 5, 2026
