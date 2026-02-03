<?php
/**
 * Simulate deletion of a user and report related records (dry-run)
 * Usage: php simulate_user_delete.php <userId>
 */
require __DIR__ . '/../App/Config/Database.php';
require __DIR__ . '/../App/Core/Model.php';
require __DIR__ . '/../App/Models/Order.php';

use App\Config\Database;
use App\Models\Order;

if ($argc < 2) {
    echo "Usage: php simulate_user_delete.php <userId>\n";
    exit(1);
}

$userId = (int)$argv[1];
if ($userId <= 0) {
    echo "Invalid user id\n";
    exit(2);
}

try {
    $db = Database::getConnection();
} catch (Exception $e) {
    echo "DB connection failed: " . $e->getMessage() . "\n";
    exit(3);
}

echo "Simulating delete for user id: $userId\n\n";

// 1) Check user exists
$stmt = $db->prepare("SELECT id, email FROM users WHERE id = ? LIMIT 1");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    echo "User not found in users table.\n";
    exit(4);
}

echo "User: " . ($user['email'] ?? '(no email)') . " (id=$userId)\n\n";

// 2) Email verification tokens
try {
    $stmt = $db->prepare("SELECT id, token, expires_at FROM email_verification_tokens WHERE user_id = ?");
    $stmt->execute([$userId]);
    $ev = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Email verification tokens: " . count($ev) . "\n";
    if (count($ev) > 0) {
        echo "  IDs: ";
        echo implode(', ', array_map(function($r){return $r['id'];}, $ev));
        echo "\n";
    }
} catch (Exception $e) {
    echo "Email verification tokens: query failed (" . $e->getMessage() . ")\n";
}

// 3) Password resets (DB)
try {
    $stmt = $db->prepare("SELECT id, token, expires_at FROM password_resets WHERE user_id = ?");
    $stmt->execute([$userId]);
    $prs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Password reset records in DB: " . count($prs) . "\n";
    if (count($prs) > 0) {
        echo "  IDs: ";
        echo implode(', ', array_map(function($r){return $r['id'];}, $prs));
        echo "\n";
    }
} catch (Exception $e) {
    echo "Password resets (DB) query failed: " . $e->getMessage() . "\n";
}

// 4) Password resets (fallback file)
$fallback = __DIR__ . '/../storage/password_resets.json';
if (file_exists($fallback)) {
    $raw = file_get_contents($fallback);
    $arr = json_decode($raw, true) ?: [];
    $matches = array_filter($arr, function($e) use ($userId){ return (int)($e['user_id'] ?? 0) === $userId; });
    echo "Password reset records in fallback JSON: " . count($matches) . "\n";
} else {
    echo "Password reset fallback file not present.\n";
}

// 5) Orders and order_items
try {
    $stmt = $db->prepare("SELECT id, total, status, created_at FROM orders WHERE user_id = ?");
    $stmt->execute([$userId]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Orders for user: " . count($orders) . "\n";
    if (count($orders) > 0) {
        $ids = array_map(function($o){return $o['id'];}, $orders);
        echo "  Order IDs: " . implode(', ', $ids) . "\n";

        // count order_items per order
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt2 = $db->prepare("SELECT order_id, COUNT(*) as cnt FROM order_items WHERE order_id IN ($placeholders) GROUP BY order_id");
        $stmt2->execute($ids);
        $items = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($items as $it) {
            echo "    Order " . $it['order_id'] . " items: " . $it['cnt'] . "\n";
        }
    }
} catch (Exception $e) {
    echo "Orders query failed: " . $e->getMessage() . "\n";
}

// 6) Other checks: email in other tables (admin views, logs) - list quick references
try {
    $stmt = $db->prepare("SELECT COUNT(*) as c FROM orders WHERE user_id NOT IN (SELECT id FROM users)");
    $stmt->execute();
    $bad = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "\nDatabase integrity check: orphan orders count: " . ($bad['c'] ?? 0) . "\n";
} catch (Exception $e) { }

echo "\nSimulation complete. No data was modified.\n";

?>