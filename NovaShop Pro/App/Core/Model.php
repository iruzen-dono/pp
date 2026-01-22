<?php
namespace App\Core;

require_once __DIR__ . '/../Config/Database.php';

use App\Config\Database;
use PDO;

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }

    protected function prepare($query)
    {
        return $this->db->prepare($query);
    }

    protected function execute($stmt, $params = [])
    {
        return $stmt->execute($params);
    }

    protected function fetch($stmt)
    {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    protected function fetchAll($stmt)
    {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
