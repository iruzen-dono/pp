<?php
namespace App\Models;

use App\Core\Model;

class Order extends Model
{
    public function getAll(): array
    {
        return $this->run(
            "SELECT * FROM orders ORDER BY created_at DESC"
        );
    }

    public function getById(int $id): ?array
    {
        return $this->run(
            "SELECT * FROM orders WHERE id = ? LIMIT 1",
            [$id],
            true
        );
    }

    public function getByUserId(int $userId): array
    {
        return $this->run(
            "SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC",
            [$userId]
        );
    }

    public function create(int $userId, float $total = 0): int
    {
        $this->run(
            "INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'pending')",
            [$userId, $total]
        );

        return (int) $this->db->lastInsertId();
    }

    public function update(int $id, string $status, float $total): int
    {
        return $this->run(
            "UPDATE orders SET status = ?, total = ? WHERE id = ?",
            [$status, $total, $id]
        );
    }

    public function delete(int $id): int
    {
        return $this->run(
            "DELETE FROM orders WHERE id = ?",
            [$id]
        );
    }
}
