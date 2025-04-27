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

    public static function update($projectId, $name, $description) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE projects 
            SET name = :name, description = :description 
            WHERE id = :project_id
        ');

        return $stmt->execute([
            'project_id' => $projectId,
            'name' => $name,
            'description' => $description,
        ]);
    }

    public static function delete($projectId) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            DELETE FROM projects WHERE id = :project_id
        ');

        return $stmt->execute([
            'project_id' => $projectId,
        ]);
    }
}