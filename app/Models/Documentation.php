<?php

namespace App\Models;

use Core\Database;

class Documentation
{
    public static function create(string $title, string $content, string $projectId, string $userId): int{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO documantation (title, content, project_id, user_id) 
            VALUES (:title, :content, :projectId, :userId);
        ");
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":projectId", $projectId);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();

        return $db->lastInsertId();

    }

    public static function update(string $id, string $title, string $content): bool {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            UPDATE documantation 
            SET title = :title, content = :content 
            WHERE id = :id;
        ");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        return $stmt->execute();
    }

    public static function getAll(string $userId): array{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM documantation 
            WHERE user_id = :userId;
        ");
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    
    public static function getById(string $id){
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM documantation 
            WHERE id = :id;
        ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function getAllByProjectId($projectId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM documantation 
            WHERE project_id = :projectId;  
            ");
            
        $stmt->bindParam(":projectId", $projectId);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public static function delete(string $id): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            DELETE FROM documantation 
            WHERE id = :id;
        ");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

}