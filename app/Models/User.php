<?php

namespace App\Models;

use Core\Database;
use PDO;

class User
{
    public static function create($name, $email = null, $password = null)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            INSERT INTO users (name, email, password)
            VALUES (:name, :email, :password)
        ');

        if ($password !== null) {
            $password = password_hash($password, PASSWORD_BCRYPT);
        }

        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);

        return self::getLastInsertId();
    }

    public static function findByEmail($email)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function getLastInsertId()
    {
        $db = Database::getInstance();
        return $db->lastInsertId();
    }
}
