# Testing Guide

## Manual Test Scenarios

### 1. User Registration & Login

**Objective:** Verify user can register and login

**Steps:**
1. Navigate to `http://localhost:8000/register`
2. Fill in:
   - Email: `newuser@test.fr`
   - Password: `Test@123`
   - Confirm: `Test@123`
   - Accept terms
3. Click "Register"
4. Should redirect to login
5. Login with credentials above
6. Should redirect to products page

**Expected Results:**
- ✅ Account created in database
- ✅ Session established
- ✅ Redirect to products page
- ✅ Navbar shows user name

---

### 2. Browse Products

**Objective:** Verify product listing and variants display

**Steps:**
1. Go to `http://localhost:8000/products`
2. View product grid
3. Click on any product
4. View product details page

**Expected Results:**
- ✅ All products display with images
- ✅ Product details visible (name, price, description)
- ✅ Variants dropdown if applicable
- ✅ "Add to Cart" button functional

---

### 3. Shopping Cart

**Objective:** Test cart operations

**Steps:**
1. Add 2-3 products to cart
2. Go to cart page (`/cart`)
3. Modify quantities
4. Remove one item
5. Proceed to checkout

**Expected Results:**
- ✅ Items persist in cart
- ✅ Price calculations correct
- ✅ Quantity updates work
- ✅ Removal works

---

### 4. Order Placement

**Objective:** Complete purchase flow

**Steps:**
1. From cart, click "Checkout"
2. Fill shipping info
3. Click "Place Order"
4. View order confirmation

**Expected Results:**
- ✅ Order created in database
- ✅ Order items linked correctly
- ✅ Order status = "pending"
- ✅ User can view order in "My Orders"

---

### 5. Admin Panel Access

**Objective:** Verify admin-only access

**Login as Admin:**
- Email: `admin@test.fr`
- Password: `admin123`

**Steps:**
1. Login with admin account
2. Navigate to admin dashboard
3. Try adding new product
4. Try managing users

**Expected Results:**
- ✅ Admin dashboard accessible
- ✅ All admin menus visible
- ✅ Regular users cannot access `/admin`
- ✅ Create/edit product forms work

---

### 6. Admin - User Role Management

**Objective:** Test role changing

**Steps:**
1. Login as admin
2. Go to Users management
3. Select a user
4. Change role to "moderator"
5. Verify role updated

**Expected Results:**
- ✅ Role changed in database
- ✅ User has new permissions
- ✅ CSRF validation passed

---

### 7. Password Reset

**Objective:** Test forgot password flow

**Steps:**
1. Go to login page
2. Click "Forgot Password?"
3. Enter email
4. Check database for token (or email if configured)
5. Use token to reset password

**Expected Results:**
- ✅ Token created in database
- ✅ Token valid for reset
- ✅ Password updated successfully
- ✅ Can login with new password

---

## Automated Test Checklist

- [ ] Database seeds without errors
- [ ] 34 products created with images
- [ ] 4 test users created
- [ ] Default admin account works
- [ ] Homepage loads (200 OK)
- [ ] All assets load (CSS, JS, images)
- [ ] No PHP errors in logs
- [ ] All forms have CSRF tokens

---

## Test Accounts

| Email | Password | Role |
|-------|----------|------|
| user@test.fr | password123 | user |
| admin@test.fr | admin123 | admin |
| moderator@test.fr | password123 | moderator |

(Create moderator manually for testing)

---

## Performance Testing

Check response times:
```bash
# From browser DevTools Network tab
# Most pages should load in < 1 second
```

Check image optimization:
```bash
# Product images should be ~40-70KB each (JPG format)
# Total page size < 2MB
```

---

**Last updated:** February 5, 2026
