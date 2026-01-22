<?php
namespace App\Config;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;

    public static function getConnection()
    {
        if (self::$instance === null) {
            try {
                $options = [
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
                ];

                self::$instance = new PDO(
                    "mysql:host=localhost;dbname=novashop;charset=utf8mb4",
                    "root",
                    "0000",
                    $options
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Force compatibility avec MariaDB 12+
                self::$instance->exec("SET SESSION sql_mode='STRICT_TRANS_TABLES,NO_ZERO_DATE,NO_ZERO_IN_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'");
            } catch (PDOException $e) {
                die("Erreur DB : " . $e->getMessage());
            }
        }

        return self::$instance;
    }
}
