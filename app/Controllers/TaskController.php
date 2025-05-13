<?php

namespace App\Controllers;

use App\Models\Board;
use App\Models\Label;
use App\Models\Task;

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
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = $errors;
            
            // Determine where to redirect
            if (!empty($boardId)) {
                $board = Board::getById($boardId);
                $projectId = $board ? $board['project_id'] : null;
                if ($projectId) {
                    header('Location: /dashboard/' . $projectId);
                    exit;
                }
            }
            
            // Fallback redirect
            header('Location: /');
            exit;
        }
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user']['id'] ?? null;
        
        if (!$userId) {
            $_SESSION['errors'] = ['User not logged in'];
            header('Location: /login');
            exit;
        }

        $boardTasks = Task::getAllByBoardId($boardId);
        $position = count($boardTasks) + 1; // Posição da tarefa na lista (incrementa a contagem de tarefas existentes)

        // Chama o método create da classe Task para inserir a tarefa no banco de dados
        $taskId = Task::create($title, $description, $boardId, $userId, $expiredAt, $position);

        // Redireciona para a página do dashboard após a inserção
        $message = [];
        if ($taskId) {
            $message['message'] = 'Task created successfully!';
        } else {
            $message['message'] = 'Error creating the task.';
        }

        $board = Board::getById($boardId);
        $projectId = $board['project_id'];

        header('Location: /dashboard/' . $projectId);
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
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = $errors;
            
            if (!empty($project_id)) {
                header('Location: /dashboard/' . $project_id);
                exit;
            } else {
                header('Location: /');
                exit;
            }
        }

        Task::update($id, $title, $description, $expired_at);
        
        // Update task labels
        Label::removeAllFromTask($id);
        foreach ($labelIds as $labelId) {
            Label::assignToTask($id, $labelId);
        }

        header('Location: /dashboard/' . $project_id);
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
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = $errors;
            
            if (!empty($projectId)) {
                header('Location: /dashboard/' . $projectId);
                exit;
            } else {
                header('Location: /');
                exit;
            }
        }
        
        Task::delete($id);
        
        header('Location: /dashboard/' . $projectId);
    }
}