<?php
namespace App\Models;

use App\Core\Model;

require_once __DIR__ . '/../Core/Model.php';

class Order extends Model
{
    public function getAll()
    {
        $stmt = $this->prepare("SELECT * FROM orders");
        $this->execute($stmt);
        return $this->fetchAll($stmt);
    }

    public function getById($id)
    {
        $stmt = $this->prepare("SELECT * FROM orders WHERE id = ? LIMIT 1");
        $this->execute($stmt, [$id]);
        return $this->fetch($stmt);
    }

    public function getByUserId($userId)
    {
        $stmt = $this->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $this->execute($stmt, [$userId]);
        return $this->fetchAll($stmt);
    }

    public function create($userId)
    {
        $stmt = $this->prepare(
            "INSERT INTO orders (user_id, total, status) VALUES (?, 0, 'pending')"
        );
        $this->execute($stmt, [$userId]);
        return $this->db->lastInsertId();
    }

    public function update($id, $status, $total)
    {
        $stmt = $this->prepare(
            "UPDATE orders SET status = ?, total = ? WHERE id = ?"
        );
        return $this->execute($stmt, [$status, $total, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->prepare("DELETE FROM orders WHERE id = ?");
        return $this->execute($stmt, [$id]);
    }
}
