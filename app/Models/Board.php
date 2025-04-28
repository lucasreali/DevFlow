<?php

namespace App\Models;

use Core\Database;

class Board
{

    public static function create($title, $color, $projectId, $position)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('
            INSERT INTO boards (title, color, project_id, position)
            VALUES (:name, :color, :project_id, :position)
        ');
        $stmt->execute([
            'name' => $title,
            'color' => $color,
            'project_id' => $projectId,
            'position' => $position,
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