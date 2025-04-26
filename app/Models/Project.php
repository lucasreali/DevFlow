<?php

namespace App\Models;

use Core\Database;

class Project
{
    public static function create($userId, $name) {

        $db = Database::getInstance();
        $stmt = $db->prepare('
            INSERT INTO projects (user_id, name)
            VALUES (:user_id, :name)
        ');

        $stmt->execute([
            'user_id' => $userId,
            'name' => $name,
        ]);
        return $db->lastInsertId();
    }

    public static function getAll($userId) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT * FROM projects WHERE user_id = :user_id
        ');

        $stmt->execute([
            'user_id' => $userId,
        ]);
        return $stmt->fetchAll();
    }

    public static function getById($projectId) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT * FROM projects WHERE id = :project_id
        ');

        $stmt->execute([
            'project_id' => $projectId,
        ]);
        return $stmt->fetch();
    }


}