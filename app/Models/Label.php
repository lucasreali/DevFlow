<?php

namespace App\Models;

use Core\Database;

class Label {
    public static function create($title, $color, $project) {
        $db = Database::getInstance();

        $stmt = $db->prepare('
        INSERT INTO labels (title, color, project_id)
        VALUES (:title, :color, :project_id)
        ');
        $stmt->execute([
            'title' => $title,
            'color' => $color,
            'project_id' => $project,
        ]);
        return $db->lastInsertId();
    }

    public static function getByProjectId($projectId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT 
                labels.title AS title,
                tasks.id AS task_id,
                labels.color AS color
            FROM task_labels
            INNER JOIN labels ON labels.id = task_labels.label_id
            INNER JOIN tasks ON tasks.id = task_labels.task_id
            INNER JOIN boards ON boards.id = tasks.board_id
            WHERE labels.project_id = :project_id
        ');
        $stmt->execute(['project_id' => $projectId]);
        return $stmt->fetchAll();
    }

    public static function findByUserId($userId)
    {
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare('SELECT * FROM labels WHERE user_id = :user_id');
            $stmt->execute(['user_id' => $userId]);
            $label = $stmt->fetch();
            return $label ?: null;
        } 
        catch (\PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }

    public static function updateByUserId($userId, $title, $color)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE labels
            SET 
                title = :title,
                color = :color
            WHERE user_id = :user_id'
        );
        return $stmt->execute([
            'title' => $title,
            'color' => $color,
            'user_id' => $userId,
        ]);
    }

}

