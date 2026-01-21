<?php
namespace App\Models;

use App\Core\Model;

require_once __DIR__ . '/../Core/Model.php';

class OrderItem extends Model
{
    public function getByOrderId($orderId)
    {
        $stmt = $this->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $this->execute($stmt, [$orderId]);
        return $this->fetchAll($stmt);
    }

    public function create($orderId, $productId, $quantity, $price)
    {
        $stmt = $this->prepare(
            "INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)"
        );
        return $this->execute($stmt, [$orderId, $productId, $quantity, $price]);
    }

    public function delete($id)
    {
        $stmt = $this->prepare("DELETE FROM order_items WHERE id = ?");
        return $this->execute($stmt, [$id]);
    }
}
