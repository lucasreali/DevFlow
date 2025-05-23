<?php 
namespace App\Models;

use Core\Database;

class Task 
{
    // Criando a função para inserir uma nova tarefa no banco de dados. Que recebe os parâmetros necessários.
    public static function create($title, $description, $boardId, $userId, $expiredAt, $position, $priority = 'Normal') {
        $db = Database::getInstance();

        $stmt = $db->prepare(
            "INSERT INTO tasks (title, description, board_id, user_id, expired_at, position, priority) 
             VALUES (:title, :description, :board_id, :user_id, :expired_at, :position, :priority)"
        );

        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'board_id' => $boardId,
            'user_id' => $userId,
            'expired_at' => $expiredAt,
            'position' => $position,
            'priority' => $priority
        ]);

        return $db->lastInsertId();
    }

    // Criando a função para buscar todas as tarefas, por meio do board ID
    public static function getAllByBoardId($boardId){
        $db = Database::getInstance();

        $stmt = $db->prepare(
            "SELECT * FROM tasks 
             WHERE board_id = :board_id 
             ORDER BY position ASC"
        );
        $stmt->execute(['board_id' => $boardId]);
        return $stmt->fetchAll();
    }

    // Criando a função para buscar uma tarefa por ID
    public static function getById($id) {
        $db = Database::getInstance();

        $stmt = $db->prepare("SELECT * FROM tasks WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    // Criando a função para atualizar uma tarefa
    public static function update($id, $title, $description, $expiredAt, $priority = 'Normal') {
        $db = Database::getInstance();

        $stmt = $db->prepare("UPDATE tasks SET title = :title, description = :description, expired_at = :expired_at, priority = :priority WHERE id = :id");

        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'expired_at' => $expiredAt,
            'priority' => $priority
        ]);
    }

    // Criando a função para atualizar a prioridade de uma tarefa
    public static function updatePriority($id, $priority) {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE tasks SET priority = :priority WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'priority' => $priority
        ]);
    }

    // Criando a função para excluir uma tarefa
    public static function delete($id) {
        $db = Database::getInstance();

        $stmt = $db->prepare("DELETE FROM tasks WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}