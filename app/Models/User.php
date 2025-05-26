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

        return $db->lastInsertId();
    }

    public static function findByEmail($email)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findById($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function findByUsername($username)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT users.*, accounts.username
            FROM users
            INNER JOIN accounts ON accounts.user_id = users.id
            WHERE accounts.username = :username
        ');
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Updates a user's profile information
     *
     * @param int $id User ID
     * @param array $data Data to update (name, email, and optionally password)
     * @return bool Whether the update was successful
     */
    public static function update($id, $data)
    {
        $db = Database::getInstance();
        
        // Start building the SQL statement based on what we're updating
        $sql = 'UPDATE users SET name = :name, email = :email';
        $params = [
            'id' => $id,
            'name' => $data['name'],
            'email' => $data['email'],
        ];
        
        // If a new password is provided, add it to the update
        if (!empty($data['new_password'])) {
            $sql .= ', password = :password';
            $params['password'] = password_hash($data['new_password'], PASSWORD_BCRYPT);
        }
        
        $sql .= ' WHERE id = :id';
        
        $stmt = $db->prepare($sql);
        return $stmt->execute($params);
    }

    /**
     * Verifies if the provided password matches the user's stored password
     *
     * @param int $id User ID
     * @param string $password Password to verify
     * @return bool Whether the password is correct
     */
    public static function verifyPassword($id, $password)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT password FROM users WHERE id = :id');
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$user) {
            return false;
        }
        
        return password_verify($password, $user['password']);
    }
}
