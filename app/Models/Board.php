<?php

namespace App\Models;

use Core\Database;

class Board
{

    public static function create($userId, $title, $color, $projectId)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('
            INSERT INTO boards (user_id, title, color, project_id)
            VALUES (:user_id, :name, :color, :project_id)
        ');
        $stmt->execute([
            'user_id' => $userId,
            'name' => $title,
            'color' => $color,
            'project_id' => $projectId,
        ]);

        return $db->lastInsertId();
    }

    public static function getAll($userId)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('
            SELECT * FROM boards WHERE user_id = :user_id
        ');
        $stmt->execute(['user_id' => $userId]);

        return $stmt->fetchAll();
    }
    
}