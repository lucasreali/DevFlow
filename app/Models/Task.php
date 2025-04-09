<?php 
namespace App\Models;

use Core\Database; // importar a classe Database

class Task 
{

 //criando a function para inserir
    public static function create($title, $description, $boardId, $createdBy, $expiredAt) {
        $db = Database::getInstance(); //pega  a instância do banco de dados (tabela) 

        $stmt = $db->prepare( //preparando a query
         "INSERT INTO tasks (title, description, board_id, created_by, expired_at) VALUES (:title, :description, :board_id, :created_by, :expired_at, NOW(), NOW())"
        );

// Executa a consulta SQL (query) no banco de dados, inserindo os valores fornecidos
$stmt->execute([
    'title' => $title,        // Insere o título fornecido
    'description' => $description,  // Insere a descrição fornecida
    'board_id' => $boardId,  // Insere o ID do quadro/board fornecido
    'created_by' => $createdBy,  
    'expired_at' => $expiredAt // Insere a data de expiração fornecida
]);

    //Retorna o ID que foi automaticamente gerado pelo banco de dados
    //para o último registro inserido (normalmente usado quando a tabela tem uma coluna auto-incremento)
    return $db->lastInsertId();
    } 


}