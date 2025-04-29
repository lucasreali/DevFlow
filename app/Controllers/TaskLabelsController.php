<?php

namespace App\Controllers;

use App\Models\TaskLabels;

class TaskLabelsController
{
    public function create()
    {
        $labelId = $_POST['label_id'] ?? null;
        $taskId = $_POST['task_id'] ?? null;
        $projectId = $_POST['project_id'] ?? null;
        
        if (!$labelId || !$taskId) {
            throw new \InvalidArgumentException('Label ID and Task ID are required');
        }

        if (TaskLabels::create($labelId, $taskId)) {
            header('Location: /dashboard/' . $projectId);
            exit;
        } else {
            throw new \RuntimeException('Failed to assign label to task');
        }
    }

    public function delete()
    {
        $labelId = $_POST['label_id'] ?? null;
        $taskId = $_POST['task_id'] ?? null;
        $projectId = $_POST['project_id'] ?? null;
        
        if (!$labelId || !$taskId) {
            throw new \InvalidArgumentException('Label ID and Task ID are required');
        }

        if (TaskLabels::deleteByTaskId($taskId, $labelId)) {
            header('Location: /dashboard/' . $projectId);
            exit;
        } else {
            throw new \RuntimeException('Failed to remove label from task');
        }
    }
    
    public function getByTaskId($data)
    {
        $taskId = $data['taskId'] ?? null;
        
        if (!$taskId) {
            http_response_code(400);
            echo json_encode(['error' => 'Task ID is required']);
            return;
        }
        
        $labels = TaskLabels::getByTaskId($taskId);
        
        header('Content-Type: application/json');
        echo json_encode(['labels' => $labels]);
    }
}