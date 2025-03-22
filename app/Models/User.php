<?php

namespace App\Models;

use Core\Database;
use PDO;

class User
{
    public static function create($name, $email, $password)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            INSERT INTO users (name, email, password)
            VALUES (:name, :email, :password)
        ');

        return $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
        ]);
    }

    public static function findByEmail($email)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
