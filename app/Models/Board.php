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

    public static function getById($id)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('
            SELECT * FROM boards WHERE id = :id
        ');
        $stmt->execute(['id' => $id]);

        return $stmt->fetch();
    }
    
    public static function update($id, $title, $color)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('UPDATE boards SET title = :title, color = :color WHERE id = :id');
        return $stmt->execute([
            'title' => $title,
            'color' => $color,
            'id' => $id,
        ]);
    }

    public static function delete($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('DELETE FROM boards WHERE id = :id');
        return $stmt->execute(['id' => $id]);
    }
}