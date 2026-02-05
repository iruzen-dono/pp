# Admin Panel Guide

## Accessing Admin Dashboard

1. Login with admin account:
   - Email: `admin@test.fr`
   - Password: `admin123`

2. Navigate to: `http://localhost:8000/admin`

---

## Admin Features

### 1. Dashboard Overview

Main admin page shows:
- Total users
- Total products
- Total orders
- Quick links to management pages

---

### 2. User Management

**Access:** Admin > Users

#### View Users
- List all users with columns: ID, Email, Role, Actions
- Search/filter functionality

#### Change User Role

Roles available:
- `user` - Regular customer
- `moderator` - Can moderate content (if implemented)
- `admin` - Full admin access
- `super_admin` - Complete system access

**Steps to change role:**
1. Go to Users page
2. Find user row
3. Click "Change Role" button
4. Select new role
5. Confirm

**Note:** All role changes require CSRF token (automatic in forms).

#### Delete User
- Removes user account
- Orders remain in system with user_id reference

---

### 3. Product Management

**Access:** Admin > Products

#### Add Product

**Form Fields:**
- **Name** - Product title (required)
- **Description** - Product details (rich text)
- **Price** - Numeric price (required)
- **Category** - Select from dropdown
- **Image** - Upload or select file
- **Variants** - Comma-separated options (e.g., "Small, Medium, Large")

**Variants Format:**
```
Red, Blue, Green
S, M, L, XL
Standard, Deluxe, Premium
```

**Steps:**
1. Click "Add Product"
2. Fill all fields
3. Click "Save"
4. If successful, redirected to product list
5. New product appears in catalog

#### Edit Product

**Steps:**
1. Go to Products list
2. Find product
3. Click "Edit"
4. Modify fields
5. Click "Update"

#### Delete Product

**Steps:**
1. Go to Products list
2. Find product
3. Click "Delete" 
4. Confirm deletion

**Note:** This removes product but doesn't affect completed orders.

---

### 4. Order Management

**Access:** Admin > Orders

#### View Orders

List shows:
- Order ID
- Customer email
- Order date
- Status (pending, processing, completed, cancelled)
- Total amount

#### View Order Details

Click on any order to see:
- Items in order with quantities
- Unit prices
- Shipping address (when implemented)

#### Update Order Status

**Steps:**
1. Click on order
2. Change status dropdown
3. Save changes

**Available Statuses:**
- `pending` - Just placed
- `processing` - Being prepared
- `shipped` - In transit
- `delivered` - Received

---

### 5. Category Management

**Access:** Admin > Categories

#### Add Category
1. Enter category name
2. Click "Create"

#### Edit Category
1. Click "Edit" on category
2. Modify name
3. Save

#### Delete Category
1. Click "Delete"
2. Confirm

**Note:** Cannot delete categories with products. Must move/delete products first.

---

## Security Features

### CSRF Protection

All admin forms include CSRF tokens automatically. If you see:
```
CSRF Token Error
```

**Solution:** Try action again (token expires after 25 minutes).

### Role-Based Access

- Only `admin` and `super_admin` can access admin panel
- Regular users can only see own orders
- Moderators (if enabled) see limited features

---

## Common Tasks

### Add 10 New Products Quickly

1. Go to Products
2. Click "Add Product" for each
3. Use template:
   - Name: descriptive
   - Price: realistic
   - Category: appropriate
   - Variants: if applicable
   - Description: brief
4. Upload image from Assets/Images/

### Bulk Import

No bulk import UI exists. Use:
```bash
php scripts/seed_complete_data.php
```

Or write custom script to loop through CSV.

### View Database Directly

```bash
mysql -u root -p0000 novashop
SELECT * FROM products;
SELECT * FROM users;
```

---

## Troubleshooting

### "Access Denied"
- Verify logged in as admin
- Check user role: `SELECT role FROM users WHERE email='admin@test.fr';`

### Form not submitting
- Check CSRF token error message
- Refresh page and retry

### Product image not showing
- Verify file uploaded to `/Public/Assets/Images/products/`
- Check file permissions (755)
- Try PNG/JPG only (not WEBP)

---

**Last updated:** February 5, 2026
