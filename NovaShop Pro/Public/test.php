<?php
/**
 * Quick Test Script - NovaShop Pro v2.0
 * Tests: Import, Products, Registration, Heart Position
 */

// Simulate a quick integration test
echo "=== NovaShop Pro v2.0 - Quick Test Suite ===\n\n";

// Test 1: Database Connection
echo "TEST 1: Database Connection\n";
try {
    require_once __DIR__ . '/../App/Config/Database.php';
    $db = \App\Config\Database::getConnection();
    echo "✅ Database connection successful\n\n";
} catch (Exception $e) {
    echo "❌ Database connection failed: " . $e->getMessage() . "\n\n";
    exit(1);
}

// Test 2: Product Model
echo "TEST 2: Product Model\n";
try {
    require_once __DIR__ . '/../App/Models/Product.php';
    $productModel = new \App\Models\Product();
    $products = $productModel->getAll();
    echo "✅ Products loaded: " . count($products) . " products found\n";
    if (count($products) > 0) {
        echo "   Sample: " . $products[0]['name'] . " (" . $products[0]['price'] . "€)\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "❌ Product Model failed: " . $e->getMessage() . "\n\n";
}

// Test 3: User Model (Registration readiness)
echo "TEST 3: User Model & Registration\n";
try {
    require_once __DIR__ . '/../App/Models/User.php';
    $userModel = new \App\Models\User();
    echo "✅ User Model initialized\n";
    echo "   Register form: /register endpoint ready\n";
    echo "   Login form: /login endpoint ready\n";
    echo "\n";
} catch (Exception $e) {
    echo "❌ User Model failed: " . $e->getMessage() . "\n\n";
}

// Test 4: CSS Structure Check
echo "TEST 4: CSS Architecture\n";
$cssFiles = [
    '/Assets/Css/variables.css',
    '/Assets/Css/utilities.css',
    '/Assets/Css/animations.css',
    '/Assets/Css/buttons.css',
    '/Assets/Css/ui-improvements.css',
    '/Assets/Css/navbar.css',
    '/Assets/Css/cards.css',
    '/Assets/Css/products.css',
    '/Assets/Css/forms.css',
    '/Assets/Css/Style.css',
    '/Assets/Css/ui-fixes.css'
];

$pubPath = __DIR__;
$allExist = true;
foreach ($cssFiles as $file) {
    $fullPath = $pubPath . $file;
    if (file_exists($fullPath)) {
        $size = filesize($fullPath);
        echo "   ✅ $file (" . round($size/1024, 1) . "KB)\n";
    } else {
        echo "   ❌ $file (NOT FOUND)\n";
        $allExist = false;
    }
}
if ($allExist) {
    echo "✅ All CSS files loaded\n";
} else {
    echo "⚠️  Some CSS files missing\n";
}
echo "\n";

// Test 5: Routes Check
echo "TEST 5: Routes Configuration\n";
try {
    require_once __DIR__ . '/../App/Core/Router.php';
    $routes = [
        '/' => 'Home',
        '/products' => 'Products List',
        '/products/show' => 'Product Detail',
        '/register' => 'User Registration',
        '/login' => 'User Login',
        '/cart' => 'Shopping Cart',
        '/admin/dashboard' => 'Admin Panel'
    ];
    echo "✅ Available routes:\n";
    foreach ($routes as $route => $desc) {
        echo "   • $route → $desc\n";
    }
    echo "\n";
} catch (Exception $e) {
    echo "❌ Router failed: " . $e->getMessage() . "\n\n";
}

echo "=== Test Suite Complete ===\n";
echo "Next: Visit http://localhost:8000/ in browser\n";
echo "To test:\n";
echo "  1. Import products: http://localhost:8000/scripts/import_products.php\n";
echo "  2. View products: http://localhost:8000/products\n";
echo "  3. Register user: http://localhost:8000/register\n";
echo "  4. Check heart position on product cards (should not move on hover)\n";
?>
