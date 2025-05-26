<?php

namespace App\Models;

use Core\Database;

class Documentation
{
    public static function create(string $title, string $content, string $projectId, string $userId, string $doc_type = 'project'): int{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO documentation (title, content, project_id, user_id, doc_type) 
            VALUES (:title, :content, :projectId, :userId, :doc_type);
        ");
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":projectId", $projectId);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":doc_type", $doc_type);
        $stmt->execute();

        return $db->lastInsertId();
    }

    public static function update(string $id, string $title, string $content, string $doc_type = 'project'): bool {
        $db = Database::getInstance();
        
        $stmt = $db->prepare("
            UPDATE documentation 
            SET title = :title, content = :content, doc_type = :doc_type 
            WHERE id = :id;
        ");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":doc_type", $doc_type);
        return $stmt->execute();
    }

    public static function getAll(string $userId): array{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM documentation 
            WHERE user_id = :userId;
        ");
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    
    public static function getById(string $id){
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM documentation 
            WHERE id = :id;
        ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    public static function getAllByProjectId($projectId, $doc_type = null)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM documentation WHERE project_id = :projectId";
        $params = [":projectId" => $projectId];
        
        if ($doc_type && $doc_type !== 'All') {
            $sql .= " AND doc_type = :doc_type";
            $params[":doc_type"] = $doc_type;
        }
            
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }

    public static function delete(string $id): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            DELETE FROM documentation 
            WHERE id = :id;
        ");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

}