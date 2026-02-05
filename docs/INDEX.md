# 📚 Documentation Index

Quick navigation to all documentation.

## Getting Started (Start here!)

1. **[SETUP.md](SETUP.md)** — Installation & quick start (5 min)
   - Database creation
   - Dependencies installation
   - Start development server
   - Test data seeding

2. **[TESTING.md](TESTING.md)** — Manual test scenarios (20 min)
   - User registration & login
   - Product browse & purchase
   - Admin features
   - All test accounts

## User Guides

- **[ADMIN.md](ADMIN.md)** — Admin panel complete guide
  - User management
  - Product management
  - Order tracking
  - Role-based access

- **[VARIANTS.md](VARIANTS.md)** — Product variants explained
  - How variants work
  - Admin: adding variants
  - Frontend: dropdown display
  - Examples & best practices

## Troubleshooting

- **[TROUBLESHOOTING.md](TROUBLESHOOTING.md)** — Common issues & fixes
  - Server startup issues
  - Database connection
  - Image display problems
  - Login/authentication
  - CSRF errors
  - Performance optimization

---

## File Structure

```
docs/
├── INDEX.md                    # This file
├── SETUP.md                   # Quick start & installation
├── TESTING.md                 # Test scenarios  
├── ADMIN.md                   # Admin panel guide
├── VARIANTS.md                # Product variants
└── TROUBLESHOOTING.md         # Common problems & solutions
```

---

## Quick Reference

### Most Common Tasks

| Task | Location |
|------|----------|
| Install & run | [SETUP.md](SETUP.md) - Follow "Quick Start" |
| Add products | [ADMIN.md](ADMIN.md) - Product Management section |
| Test everything | [TESTING.md](TESTING.md) - Run all scenarios |
| Fix images | [TROUBLESHOOTING.md](TROUBLESHOOTING.md) #3 |
| Understand variants | [VARIANTS.md](VARIANTS.md) - What are Variants? |

### Test Accounts

```
Admin Login:
  Email: admin@test.fr
  Password: admin123

User Login:
  Email: user@test.fr
  Password: password123
```

---

## For Developers

### Database Schema
Check `NovaShop Pro/setup.sql` for:
- Table definitions
- Relationships
- Indexes

### Code Structure
```
NovaShop Pro/
├── App/
│   ├── Controllers/     # Request handlers
│   ├── Models/         # Database models
│   ├── Services/       # Business logic
│   ├── Views/          # HTML templates
│   └── Config/         # Configuration
├── Public/
│   └── Assets/         # CSS, JS, images
└── scripts/            # Utility scripts
```

### Key Files

| File | Purpose |
|------|---------|
| `App/Config/Database.php` | Database connection |
| `App/Core/Application.php` | Framework core |
| `App/middleware/CsrfMiddleware.php` | CSRF protection |
| `Public/router.php` | URL routing |

---

## Support

If you encounter issues:

1. Check [TROUBLESHOOTING.md](TROUBLESHOOTING.md)
2. Verify database: `mysql -u root -p0000 novashop -e "SHOW TABLES;"`
3. Check PHP: `php --version`
4. Check MySQL: `mysql --version`

---

**Last Updated:** February 5, 2026  
**Project Status:** ✅ Ready to use
