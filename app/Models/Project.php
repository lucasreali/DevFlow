<?php

namespace App\Models;

use Core\Database;

class Project
{
    public static function create($userId, $name, $description) {

        $db = Database::getInstance();
        $stmt = $db->prepare('
            INSERT INTO projects (user_id, name, description)
            VALUES (:user_id, :name, :description)
        ');

        $stmt->execute([
            'user_id' => $userId,
            'name' => $name,
            'description' => $description,
        ]);
        return $db->lastInsertId();
    }
}