<?php
namespace App\Core;

use App\Config\Database;
use PDO;

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    protected function run(string $sql, array $params = [], bool $single = false)
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($params);

            if (stripos(trim($sql), 'SELECT') === 0) {
                if ($single) {
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    return $row === false ? null : $row;
                }

                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            return $stmt->rowCount();
        } catch (\PDOException $e) {
            throw new \Exception("Erreur SQL : " . $e->getMessage());
        }
    }
}
