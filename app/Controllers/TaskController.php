<?php

namespace App\Controllers;

use App\Models\Board;
use App\Models\Label;
use App\Models\Task;

class TaskController
{
    public static function store() {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $boardId = $_POST['board_id'];
        $expiredAt = $_POST['expired_at'];
        $userId = $_SESSION['user']['id']; // ID do usuário que criou a tarefa (assumindo que está na sessão)

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

    public function update()
    {
        $id = $_POST['id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $expired_at = $_POST['expired_at'];
        $project_id = $_POST['project_id'];
        $labelIds = $_POST['labels'] ?? [];

        Task::update($id, $title, $description, $expired_at);
        
        // Update task labels
        Label::removeAllFromTask($id);
        foreach ($labelIds as $labelId) {
            Label::assignToTask($id, $labelId);
        }

        header('Location: /dashboard/' . $project_id);
    }

    public static function delete() {
        $id = $_POST['id'];
        $projectId = $_POST['project_id'];

        // Chama o método delete da classe Task para excluir a tarefa do banco de dados
        Task::delete($id);

        // Redireciona para a página do dashboard após a exclusão
        header('Location: /dashboard/' . $projectId);
    }
}