<?php
namespace App\Models;

use App\Core\Model;

class Category extends Model
{
    public function getAll(): array
    {
        return $this->run(
            "SELECT * FROM categories ORDER BY name ASC"
        );
    }

    public function findById(int $id): ?array
    {
        return $this->run(
            "SELECT * FROM categories WHERE id = ? LIMIT 1",
            [$id],
            true
        );
    }

    public function create(string $name, ?string $description = null): int
    {
        return $this->run(
            "INSERT INTO categories (name, description) VALUES (?, ?)",
            [$name, $description]
        );
    }

    public function update(int $id, string $name, ?string $description = null): int
    {
        return $this->run(
            "UPDATE categories SET name = ?, description = ? WHERE id = ?",
            [$name, $description, $id]
        );
    }

    public function delete(int $id): int
    {
        return $this->run(
            "DELETE FROM categories WHERE id = ?",
            [$id]
        );
    }
}
