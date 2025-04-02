<?php

namespace App\Models;

use Core\Database;

class Documentation
{
    public static function create(string $title, string $content, string $projectId, string $userId): int{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO project_docs (title, content, project_id, created_by) 
            VALUES (:title, :content, :projectId, :userId);
        ");
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":projectId", $projectId);
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();

        return $db->lastInsertId();

    }





}