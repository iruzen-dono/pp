<?php
namespace App\Models;

use App\Core\Model;

class Product extends Model
{
    public function getAll()
    {
        return $this->run(
            "SELECT * FROM products"
        );
    }

    public function getById(int $id)
    {
        return $this->run(
            "SELECT * FROM products WHERE id = ? LIMIT 1",
            [$id],
            true
        );
    }

    public function create(array $data)
    {
        return $this->run(
            "INSERT INTO products (name, description, image_url, price, category_id, stock)
             VALUES (?, ?, ?, ?, ?, ?)",
            [
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['image_url'] ?? '',
                $data['price'] ?? 0,
                $data['category_id'] ?? 1,
                $data['stock'] ?? 0
            ]
        );
    }
    
    public function update(int $id, array $data)
    {
        return $this->run(
            "UPDATE products 
             SET name = ?, description = ?, price = ?, category_id = ?, stock = ? 
             WHERE id = ?",
            [
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['price'] ?? 0,
                $data['category_id'] ?? 1,
                $data['stock'] ?? 0,
                $id
            ]
        );
    }

    public function delete(int $id)
    {
        return $this->run(
            "DELETE FROM products WHERE id = ?",
            [$id]
        );
    }
}
