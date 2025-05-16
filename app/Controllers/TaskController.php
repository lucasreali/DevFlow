<?php

namespace App\Controllers;

use App\Models\Board;
use App\Models\Label;
use App\Models\Task;
use function Core\redirect;

class TaskController
{
    public static function store($data) {
        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;
        $boardId = $data['board_id'] ?? null;
        $expiredAt = $data['expired_at'] ?? null;
        
        // Validate all required parameters
        $errors = [];
        if (empty($title)) {
            $errors[] = 'Task title cannot be empty';
        }
        if (empty($boardId)) {
            $errors[] = 'Board ID cannot be empty';
        }
        
        // Handle validation errors
        if (!empty($errors)) {
            $errorMsg = $errors[0];
            if (!empty($boardId)) {
                $board = Board::getById($boardId);
                $projectId = $board ? $board['project_id'] : null;
                if ($projectId) {
                    return redirect('/dashboard/' . $projectId, ['error' => $errorMsg]);
                }
            }
            return redirect('/', ['error' => $errorMsg]);
        }
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user']['id'] ?? null;
        
        if (!$userId) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        $boardTasks = Task::getAllByBoardId($boardId);
        $position = count($boardTasks) + 1; // Posição da tarefa na lista (incrementa a contagem de tarefas existentes)

        // Chama o método create da classe Task para inserir a tarefa no banco de dados
        $taskId = Task::create($title, $description, $boardId, $userId, $expiredAt, $position);

        $board = Board::getById($boardId);
        $projectId = $board['project_id'];

        if ($taskId) {
            return redirect('/dashboard/' . $projectId, ['success' => 'Task created successfully!']);
        } else {
            return redirect('/dashboard/' . $projectId, ['error' => 'Error creating the task.']);
        }
    } 

    public function update($data)
    {
        $id = $data['id'] ?? null;
        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;
        $expired_at = $data['expired_at'] ?? null;
        $project_id = $data['project_id'] ?? null;
        $labelIds = $data['labels'] ?? [];
        
        // Validate all required parameters
        $errors = [];
        if (empty($id)) {
            $errors[] = 'Task ID cannot be empty';
        }
        if (empty($title)) {
            $errors[] = 'Task title cannot be empty';
        }
        if (empty($project_id)) {
            $errors[] = 'Project ID cannot be empty';
        }
        
        // Handle validation errors
        if (!empty($errors)) {
            $errorMsg = $errors[0];
            if (!empty($project_id)) {
                return redirect('/dashboard/' . $project_id, ['error' => $errorMsg]);
            } else {
                return redirect('/', ['error' => $errorMsg]);
            }
        }

        Task::update($id, $title, $description, $expired_at);
        
        // Update task labels
        Label::removeAllFromTask($id);
        foreach ($labelIds as $labelId) {
            Label::assignToTask($id, $labelId);
        }

        return redirect('/dashboard/' . $project_id, ['success' => 'Task updated successfully!']);
    }

    public static function delete($data) {
        $id = $data['id'] ?? null;
        $projectId = $data['project_id'] ?? null;
        
        // Validate all required parameters
        $errors = [];
        if (empty($id)) {
            $errors[] = 'Task ID cannot be empty';
        }
        if (empty($projectId)) {
            $errors[] = 'Project ID cannot be empty';
        }
        
        // Handle validation errors
        if (!empty($errors)) {
            $errorMsg = $errors[0];
            if (!empty($projectId)) {
                return redirect('/dashboard/' . $projectId, ['error' => $errorMsg]);
            } else {
                return redirect('/', ['error' => $errorMsg]);
            }
        }
        
        Task::delete($id);
        
        return redirect('/dashboard/' . $projectId, ['success' => 'Task deleted successfully!']);
    }
}