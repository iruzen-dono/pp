<?php
namespace App\Models;

use App\Core\Model;

class OrderItem extends Model
{
    public function getByOrderId(int $orderId): array
    {
        return $this->run(
            "SELECT * FROM order_items WHERE order_id = ?",
            [$orderId]
        );
    }

    public function create(
        int $orderId,
        int $productId,
        int $quantity,
        float $price
    ): int {
        return $this->run(
            "INSERT INTO order_items (order_id, product_id, quantity, price)
             VALUES (?, ?, ?, ?)",
            [$orderId, $productId, $quantity, $price]
        );
    }

    public function delete(int $id): int
    {
        return $this->run(
            "DELETE FROM order_items WHERE id = ?",
            [$id]
        );
    }

    public function deleteByOrderId(int $orderId): int
    {
        return $this->run(
            "DELETE FROM order_items WHERE order_id = ?",
            [$orderId]
        );
    }
}
