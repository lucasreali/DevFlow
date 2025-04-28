<?php 

namespace App\Controllers;

use App\Models\Task;
use function Core\view;



class TaskController{
    public function store() {
        $title = $_POST['title'];
        $description = $_POST['description'];
        $boardId = $_POST['board_id'];
        $createdBy = $_SESSION['user']['id']; // ID do usuário que criou a tarefa (assumindo que está na sessão)
        $expiredAt = null; // Data de expiração (opcional, pode ser nula)

        

        // Chama o método create da classe Task para inserir a tarefa no banco de dados
        $taskId = Task::create($title, $description, $boardId, $createdBy, $expiredAt);

        // Redireciona para a página do dashboard após a inserção
        $message = [];
        if ($taskId) {
            $message['message'] = 'Task created successfully!';
        } else {
            $message['message'] = 'Error creating the task.';
        }

        return view('dashboard', ['message' => $message]);
    } 
}