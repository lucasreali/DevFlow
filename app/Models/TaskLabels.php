<?php

namespace App\Models;

use Core\Database;

class TaskLabels
{
    public static function create($labelId, $taskId)
    {
        $db = Database::getInstance();

        // Check if association already exists to avoid duplicates
        $checkStmt = $db->prepare('
            SELECT COUNT(*) FROM task_labels 
            WHERE label_id = :label_id AND task_id = :task_id
        ');
        $checkStmt->execute([
            'label_id' => $labelId,
            'task_id' => $taskId,
        ]);
        
        if ($checkStmt->fetchColumn() > 0) {
            return true; // Already exists
        }

        $stmt = $db->prepare('
            INSERT INTO task_labels (label_id, task_id)
            VALUES (:label_id, :task_id)
        ');
        return $stmt->execute([
            'label_id' => $labelId,
            'task_id' => $taskId,
        ]);
    }

    public static function getByTaskId($taskId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT label_id FROM task_labels
            WHERE task_id = :task_id
        ');
        $stmt->execute(['task_id' => $taskId]);
        return array_column($stmt->fetchAll(\PDO::FETCH_ASSOC), 'label_id');
    }

    public static function deleteByTaskId($taskId, $labelId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            DELETE FROM task_labels
            WHERE task_id = :task_id AND label_id = :label_id
        ');
        return $stmt->execute([
            'task_id' => $taskId,
            'label_id' => $labelId,
        ]);
    }
    
    public static function deleteAllByTaskId($taskId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            DELETE FROM task_labels
            WHERE task_id = :task_id
        ');
        return $stmt->execute(['task_id' => $taskId]);
    }
}