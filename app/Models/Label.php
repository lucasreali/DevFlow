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
    
    public static function getAllByProjectId($projectId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT id, title, color 
            FROM labels 
            WHERE project_id = :project_id
        ');
        $stmt->execute(['project_id' => $projectId]);
        return $stmt->fetchAll();
    }
    
    public static function getByTaskId($taskId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT labels.id, labels.title, labels.color
            FROM labels
            INNER JOIN task_labels ON labels.id = task_labels.label_id
            WHERE task_labels.task_id = :task_id
        ');
        $stmt->execute(['task_id' => $taskId]);
        return $stmt->fetchAll();
    }
    
    public static function getLabelIdsByTaskId($taskId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT label_id
            FROM task_labels
            WHERE task_id = :task_id
        ');
        $stmt->execute(['task_id' => $taskId]);
        return array_column($stmt->fetchAll(), 'label_id');
    }
    
    public static function assignToTask($taskId, $labelId)
    {
        $db = Database::getInstance();
        
        // Check if relation already exists
        $checkStmt = $db->prepare('
            SELECT COUNT(*) FROM task_labels 
            WHERE task_id = :task_id AND label_id = :label_id
        ');
        $checkStmt->execute([
            'task_id' => $taskId,
            'label_id' => $labelId
        ]);
        
        if ($checkStmt->fetchColumn() > 0) {
            return true; // Label already assigned
        }
        
        $stmt = $db->prepare('
            INSERT INTO task_labels (task_id, label_id) 
            VALUES (:task_id, :label_id)
        ');
        return $stmt->execute([
            'task_id' => $taskId,
            'label_id' => $labelId
        ]);
    }
    
    public static function removeFromTask($taskId, $labelId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            DELETE FROM task_labels 
            WHERE task_id = :task_id AND label_id = :label_id
        ');
        return $stmt->execute([
            'task_id' => $taskId,
            'label_id' => $labelId
        ]);
    }
    
    // Add missing methods for updating and deleting labels
    public static function update($labelId, $title, $color) 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE labels 
            SET title = :title, color = :color 
            WHERE id = :label_id
        ');
        return $stmt->execute([
            'label_id' => $labelId,
            'title' => $title,
            'color' => $color
        ]);
    }
    
    public static function delete($labelId) 
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            DELETE FROM labels 
            WHERE id = :label_id
        ');
        return $stmt->execute([
            'label_id' => $labelId
        ]);
    }
    
    // Add method to remove all labels from a task
    public static function removeAllFromTask($taskId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            DELETE FROM task_labels 
            WHERE task_id = :task_id
        ');
        return $stmt->execute([
            'task_id' => $taskId
        ]);
    }
}

