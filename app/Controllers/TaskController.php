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
        $priority = $data['priority'] ?? 'Normal';
        $labels = $data['labels'] ?? [];
        
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
        $taskId = Task::create($title, $description, $boardId, $userId, $expiredAt, $position, $priority);

        $board = Board::getById($boardId);
        $projectId = $board['project_id'];

        if ($taskId) {
            // Assign labels to the newly created task
            if (!empty($labels) && is_array($labels)) {
                foreach ($labels as $labelId) {
                    Label::assignToTask($taskId, $labelId);
                }
            }
            
            return redirect('/dashboard/' . $projectId, ['success' => 'Task created successfully!']);
        } else {
            return redirect('/dashboard/' . $projectId, ['error' => 'Error creating the task.']);
        }
    } 

    public static function update($data)
    {
        $id = $data['id'] ?? null;
        $title = $data['title'] ?? null;
        $description = $data['description'] ?? null;
        $expiredAt = $data['expired_at'] ?? null;
        $priority = $data['priority'] ?? 'Normal';
        $projectId = $data['project_id'] ?? null;
        $labels = $data['labels'] ?? [];

        // ...validações...

        Task::update($id, $title, $description, $expiredAt, $priority);
        
        // Update task labels
        if ($id) {
            // First remove all existing labels from this task
            Label::removeAllFromTask($id);
            
            // Then add the selected labels
            if (!empty($labels) && is_array($labels)) {
                foreach ($labels as $labelId) {
                    Label::assignToTask($id, $labelId);
                }
            }
        }

        // Redireciona para o board do projeto após atualizar
        return redirect('/dashboard/' . $projectId, ['success' => 'Tarefa atualizada com sucesso!']);
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

    public static function updatePriority($data) {
        $id = $data['id'] ?? null;
        $priority = $data['priority'] ?? 'Normal';
        if ($id) {
            Task::updatePriority($id, $priority);
            return redirect('/dashboard/' . $data['project_id'], ['success' => 'Prioridade atualizada!']);
        }
        return redirect('/dashboard', ['error' => 'ID da tarefa não informado']);
    }
}