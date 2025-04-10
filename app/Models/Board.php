<?php

namespace App\Models;

use Core\Database;

class Board
{

    public static function create($title, $color, $projectId)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('
            INSERT INTO boards (title, color, project_id)
            VALUES (:name, :color, :project_id)
        ');
        $stmt->execute([
            'name' => $title,
            'color' => $color,
            'project_id' => $projectId,
        ]);

        return $db->lastInsertId();
    }

    public static function getAll($projectId)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('
            SELECT * FROM boards WHERE project_id = :project_id
        ');
        $stmt->execute(['project_id' => $projectId]);

        return $stmt->fetchAll();
    }
    
}