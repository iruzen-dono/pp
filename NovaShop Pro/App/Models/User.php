<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    public function getAll(): array
    {
        return $this->run(
            "SELECT * FROM users ORDER BY created_at DESC"
        );
    }

    public function findByEmail(string $email): ?array
    {
        return $this->run(
            "SELECT * FROM users WHERE email = ? LIMIT 1",
            [$email],
            true
        );
    }

    public function create(string $name, string $email, string $password): int
    {
        return $this->run(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)",
            [$name, $email, $password]
        );
    }

    public function delete(int $id): int
    {
        return $this->run(
            "DELETE FROM users WHERE id = ?",
            [$id]
        );
    }
}
