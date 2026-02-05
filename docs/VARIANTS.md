# Product Variants Guide

## What are Variants?

Variants are product options that customers choose when buying.

**Examples:**
- Clothing: Size (S, M, L, XL), Color (Red, Blue)
- Books: Edition (Paperback, Hardcover)
- Electronics: Storage (64GB, 128GB, 256GB)

---

## How Variants Work

Variants are stored as **comma-separated text** in the `variants` column of the products table.

### Database Storage

```sql
-- Example: T-Shirt with sizes and colors
INSERT INTO products (name, variants) VALUES (
  'T-Shirt Classic',
  'Size: S, Size: M, Size: L | Color: Red, Color: Blue, Color: Black'
);

-- Example: Book with editions
INSERT INTO products (name, variants) VALUES (
  'Clean Code',
  'Paperback, Hardcover, eBook'
);
```

---

## Admin: Adding Variants

### When Creating Product

**Form Field:** Variants (textarea)

**Format Options:**

**Simple list (comma-separated):**
```
Small, Medium, Large, X-Large
```

**With categories:**
```
Size: S, Size: M, Size: L, Size: XL | Color: Red, Color: Blue
```

**Or line-based:**
```
S / M / L / XL
Red
Blue
Green
```

### When Editing Product

1. Go to Products > Edit
2. Scroll to "Variants" field
3. Modify comma-separated list
4. Save
5. Changes appear in customer view immediately

---

## Frontend: Displaying Variants

### Product Page

When customer views product details:

1. **Variants dropdown visible** if product has variants
2. **Dropdown populated** from database
3. **Selection added to cart** when adding item

### Code Example

```php
// In product view, loop through variants:
$variants = explode(',', $product['variants']);
foreach ($variants as $variant) {
  echo '<option>' . htmlspecialchars(trim($variant)) . '</option>';
}
```

### Customer Experience

1. Browse products page (no variants shown)
2. Click product details
3. See variants dropdown (if applicable)
4. Select variant option
5. Click "Add to Cart"
6. Variant choice added to order

---

## Variants in Orders

When customer orders with variants:

1. **Order created** with selected variant
2. **Order items** stored with variant choice
3. **Admin can see** variant in order details

---

## Best Practices

### Formatting

✅ **Good:**
```
Small, Medium, Large
```

❌ **Bad:**
```
small, medium, large (inconsistent case)
Small, Medium, Large,  (trailing comma)
```

### Clarity

✅ **Good:**
```
Color: Red, Color: Blue
Size: S, Size: M, Size: L
Edition: Hardcover, Edition: Paperback
```

❌ **Ambiguous:**
```
Red, M, Paperback
```

### Limits

- **Max variants:** ~50 per product (practical limit)
- **Max characters:** 255 (database field limit)
- **Special chars:** Use pipes `|` to separate categories

---

## Examples by Category

### Clothing

```
Size: XS, Size: S, Size: M, Size: L, Size: XL, Size: XXL | Color: Black, Color: Navy, Color: White, Color: Red
```

### Books

```
Paperback, Hardcover, eBook
```

### Electronics

```
Storage: 64GB, Storage: 128GB, Storage: 256GB | Color: Space Gray, Color: Silver
```

### Shoes

```
Size: 5, Size: 6, Size: 7, Size: 8, Size: 9, Size: 10 | Color: Black, Color: White, Color: Navy
```

---

## Testing Variants

### Manual Test

1. Add product with variants: `Small, Medium, Large`
2. View product page in browser
3. Variants dropdown appears
4. Select "Medium"
5. Add to cart
6. View order → variant saved

### Database Verification

```sql
-- Check products have variants
SELECT id, name, variants FROM products WHERE variants IS NOT NULL;

-- Check orders stored variants
SELECT * FROM order_items;
```

---

## Troubleshooting Variants

### Variants not showing in dropdown

**Check:**
1. Product has `variants` field populated
2. Click "View Page Source" → see variant in HTML
3. If missing, edit product and re-save variants

### Variants showing but cutting off

**Fix:**
- Shorten variant names
- Use pipe separator: `S|M|L|XL` (instead of commas)

### Database query errors

If adding product fails with variants:
1. Check variants don't exceed 255 characters
2. No quotes or special SQL characters
3. Try simpler format: `Red, Blue, Green`

---

## Performance Impact

Variants have **minimal performance impact**:
- Stored as simple text field
- No additional database tables
- Dropdown renders in milliseconds

---

**Last updated:** February 5, 2026
