<?php

namespace App\Controllers;

use App\Models\Label;

class TaskLabelController {
    
    /**
     * Get all labels for a task
     */
    public function getTaskLabels($data) {
        $taskId = $data['taskId'] ?? null;
        
        if (!$taskId) {
            http_response_code(400);
            echo json_encode(['error' => 'Task ID is required']);
            return;
        }
        
        $labelIds = Label::getLabelIdsByTaskId($taskId);
        
        // Return JSON response
        header('Content-Type: application/json');
        echo json_encode(['labels' => $labelIds]);
    }
    
    /**
     * Update labels for a task
     */
    public function updateTaskLabels() {
        $taskId = $_POST['id'] ?? null;
        $labelIds = $_POST['labels'] ?? [];
        $projectId = $_POST['project_id'] ?? null;
        
        if (!$taskId) {
            throw new \InvalidArgumentException('Task ID is required');
        }
        
        if (!$projectId) {
            throw new \InvalidArgumentException('Project ID is required');
        }
        
        // First, remove all existing labels from the task
        Label::removeAllFromTask($taskId);
        
        // Then, add the selected labels
        foreach ($labelIds as $labelId) {
            Label::assignToTask($taskId, $labelId);
        }
        
        // Redirect back to dashboard
        header('Location: /dashboard/' . $projectId);
    }
}
