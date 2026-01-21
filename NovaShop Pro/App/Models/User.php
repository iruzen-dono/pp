<?php
namespace App\Models;

use App\Core\Model;

require_once __DIR__ . '/../Core/Model.php';

class User extends Model
{

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
