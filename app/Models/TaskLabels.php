<?php

namespace App\Models;

use Core\Database;

class TaskLabels
{
    public static function create($labelId, $taskId)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('
            INSERT INTO labels_tasks (label_id, task_id)
            VALUES (:label_id, :task_id)
        ');
        $stmt->execute([
            'label_id' => $labelId,
            'task_id' => $taskId,
        ]);
    }

    public static function getByTaskId($taskId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT * FROM labels_tasks
            WHERE task_id = :task_id
        ');
        $stmt->execute(['task_id' => $taskId]);
        return $stmt->fetchAll();
    }

    public static function deleteByTaskId($taskId, $labelId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            DELETE FROM labels_tasks
            WHERE task_id = :task_id AND label_id = :label_id
        ');
        $stmt->execute([
            'task_id' => $taskId,
            'label_id' => $labelId,
        ]);
    }
}