<?php
namespace App\Models;

use App\Core\Model;

require_once __DIR__ . '/../Core/Model.php';

class Product extends Model
{
    public function getAll()
    {
        $stmt = $this->prepare("SELECT * FROM products");
        $this->execute($stmt);
        return $this->fetchAll($stmt);
    }

    public function getById($id)
    {
        $stmt = $this->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
        $this->execute($stmt, [$id]);
        return $this->fetch($stmt);
    }

    public function create($data)
    {
        // Accepte un tableau de données
        if (is_array($data)) {
            $stmt = $this->prepare(
                "INSERT INTO products (name, description, image_url, price, category_id, stock) VALUES (?, ?, ?, ?, ?, ?)"
            );
            return $this->execute($stmt, [
                $data['name'] ?? '',
                $data['description'] ?? '',
                $data['image_url'] ?? '',
                $data['price'] ?? 0,
                $data['category_id'] ?? 1,
                $data['stock'] ?? 0
            ]);
        }
        return false;
    }

    public function update($id, $name, $description, $price, $category_id)
    {
        $stmt = $this->prepare(
            "UPDATE products SET name = ?, description = ?, price = ?, category_id = ? WHERE id = ?"
        );
        return $this->execute($stmt, [$name, $description, $price, $category_id, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->prepare("DELETE FROM products WHERE id = ?");
        return $this->execute($stmt, [$id]);
    }
}
