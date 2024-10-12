<?php

namespace Akhenaton\Models\Database;

use PDO;
use PDOException;
use Akhenaton\Exceptions\ConnectionException;


class Connection
{
    private static $pdo;

    public static function getConnection()
    {
        if (!self::$pdo) {
            $host = $_ENV['DB_HOST'];
            $db = $_ENV['DB_NAME'];
            $user = $_ENV['DB_USER'];
            $pass = $_ENV['DB_PASSWORD'];
            $charset = $_ENV['DB_CHARSET'];

            $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,                
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                throw new ConnectionException("Database connection failed: " . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
