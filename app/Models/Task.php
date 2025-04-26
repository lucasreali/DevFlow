<?php 
namespace App\Models;

use Core\Database;

class Task 
{
    // Criando a função para inserir
    public static function create($title, $description, $boardId, $createdBy, $expiredAt) {
        $db = Database::getInstance();

        $stmt = $db->prepare(
            "INSERT INTO tasks (title, description, board_id, created_by, expired_at, created_at, updated_at) 
             VALUES (:title, :description, :board_id, :created_by, :expired_at, NOW(), NOW())"
        );

        $stmt->execute([
            'title' => $title,
            'description' => $description,
            'board_id' => $boardId,
            'created_by' => $createdBy,
            'expired_at' => $expiredAt
        ]);

        return $db->lastInsertId();
    }

    // Criando a função para buscar todas as tarefas
    public static function getAllByBoardId($boardId){
        $db = Database::getInstance();

        $stmt = $db->prepare(
            "SELECT * FROM tasks 
             WHERE board_id = :board_id 
             ORDER BY created_at DESC"
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
    public static function update($id, $title, $description, $boardId, $expiredAt) {
        $db = Database::getInstance();

        $stmt = $db->prepare(
            "UPDATE tasks 
             SET title = :title, description = :description, board_id = :board_id, expired_at = :expired_at, updated_at = NOW() 
             WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'board_id' => $boardId,
            'expired_at' => $expiredAt
        ]);
    }

    // Criando a função para excluir uma tarefa
    public static function delete($id) {
        $db = Database::getInstance();

        $stmt = $db->prepare("DELETE FROM tasks WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }
}