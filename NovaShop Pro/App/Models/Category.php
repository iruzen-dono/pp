<?php
namespace App\Models;

use App\Core\Model;

require_once __DIR__ . '/../Core/Model.php';

class Category extends Model
{
    public function getAll()
    {
        $stmt = $this->prepare("SELECT * FROM categories");
        $this->execute($stmt);
        return $this->fetchAll($stmt);
    }

    public function getById($id)
    {
        $stmt = $this->prepare("SELECT * FROM categories WHERE id = ? LIMIT 1");
        $this->execute($stmt, [$id]);
        return $this->fetch($stmt);
    }

    public function create($name, $description)
    {
        $stmt = $this->prepare(
            "INSERT INTO categories (name, description) VALUES (?, ?)"
        );
        return $this->execute($stmt, [$name, $description]);
    }

    public function update($id, $name, $description)
    {
        $stmt = $this->prepare(
            "UPDATE categories SET name = ?, description = ? WHERE id = ?"
        );
        return $this->execute($stmt, [$name, $description, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->prepare("DELETE FROM categories WHERE id = ?");
        return $this->execute($stmt, [$id]);
    }
}
