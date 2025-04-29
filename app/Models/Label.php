<?php

namespace App\Models;

use Core\Database;

class Label {
    public static function create($userId, $title, $color) {
        $db = Database::getInstance();

        $stmt = $db->prepare('
        INSERT INTO labels (user_id, title, color)
        VALUES (:user_id, :title, :color)
        ');
        $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'color' => $color,
        ]);
        return $db->lastInsertId();
    }

    public static function getByProjectId($projectId) {
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare('SELECT * FROM labels WHERE project_id = :project_id');
            $stmt->execute(['project_id' => $projectId]);
            $labels = $stmt->fetchAll();
            return $labels;
        } 
        catch (\PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
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
