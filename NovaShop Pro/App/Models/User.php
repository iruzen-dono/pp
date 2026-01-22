<?php
namespace App\Models;

use App\Core\Model;

require_once __DIR__ . '/../Core/Model.php';

class User extends Model
{
    public function getAll()
    {
        $stmt = $this->prepare("SELECT * FROM users ORDER BY created_at DESC");
        $this->execute($stmt);
        return $this->fetchAll($stmt);
    }

    public function delete($id)
    {
        $stmt = $this->prepare("DELETE FROM users WHERE id = ?");
        return $this->execute($stmt, [$id]);
    }

    public function create($name, $email, $password)
    {
        $stmt = $this->prepare(
            "INSERT INTO users (name, email, password) VALUES (?, ?, ?)"
        );

        return $this->execute($stmt, [$name, $email, $password]);
    }

    public function findByEmail($email)
    {
        $stmt = $this->prepare(
            "SELECT * FROM users WHERE email = ? LIMIT 1"
        );
        $this->execute($stmt, [$email]);
        return $this->fetch($stmt);
    }
}
