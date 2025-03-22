<?php

namespace Core;

use PDO;
use PDOException;

class Database {
    private static ?PDO $connection = null;

    private function __construct() {
    }

    public static function getInstance(): PDO {
        if (self::$connection === null) {
            try {
                $host = $_ENV['DB_HOST'];
                $dbname = $_ENV['DB_NAME'];
                $username = $_ENV['DB_USER'];
                $password = $_ENV['DB_PASS'];

                $dsn = "mysql:host=$host;dbname=$dbname";
                self::$connection = new PDO($dsn, $username, $password);
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die('Failed to connect: ' . $e->getMessage());
            }
        }
        return self::$connection;
    }
}
