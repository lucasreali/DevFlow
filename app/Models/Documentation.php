<?php

namespace App\Models;

use Core\Database;

/**
 * Classe Documentation - Gerencia operações relacionadas à documentação de projetos
 * 
 * Esta classe manipula a criação, atualização, busca e exclusão de documentações no sistema.
 * A documentação pode ser de dois tipos: project (projeto) ou meeting (reunião).
 */
class Documentation
{
    /**
     * Cria um novo documento no sistema
     * 
     * @param string $title O título do documento
     * @param string $content O conteúdo do documento em formato markdown
     * @param string $projectId O ID do projeto ao qual o documento pertence
     * @param string $userId O ID do usuário que está criando o documento
     * @param string $doc_type O tipo do documento: 'project' ou 'meeting'
     * @return int O ID do documento criado
     */
    public static function create(string $title, string $content, string $projectId, string $userId, string $doc_type = 'project'): int{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            INSERT INTO documentation (title, content, project_id, user_id, doc_type) 
            VALUES (:title, :content, :projectId, :userId, :doc_type);
        ");
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":projectId", $projectId);
        $stmt->bindParam(":userId", $userId);
        $stmt->bindParam(":doc_type", $doc_type);
        $stmt->execute();

        return $db->lastInsertId();
    }

    /**
     * Atualiza um documento existente
     * 
     * @param string $id O ID do documento a ser atualizado
     * @param string $title O novo título do documento
     * @param string $content O novo conteúdo do documento
     * @param string $doc_type O tipo atualizado do documento: 'project' ou 'meeting'
     * @return bool Retorna true se a atualização for bem-sucedida
     */
    public static function update(string $id, string $title, string $content, string $doc_type = 'project'): bool {
        $db = Database::getInstance();
        
        $stmt = $db->prepare("
            UPDATE documentation 
            SET title = :title, content = :content, doc_type = :doc_type 
            WHERE id = :id;
        ");
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":doc_type", $doc_type);
        return $stmt->execute();
    }

    /**
     * Busca todos os documentos de um usuário específico
     * 
     * @param string $userId O ID do usuário
     * @return array Um array contendo todos os documentos do usuário
     */
    public static function getAll(string $userId): array{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM documentation 
            WHERE user_id = :userId;
        ");
        $stmt->bindParam(":userId", $userId);
        $stmt->execute();

        return $stmt->fetchAll();
    }
    
    /**
     * Busca um documento específico pelo ID
     * 
     * @param string $id O ID do documento
     * @return array|bool Os dados do documento ou false se não encontrado
     */
    public static function getById(string $id){
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT * FROM documentation 
            WHERE id = :id;
        ");
        $stmt->bindParam(":id", $id);
        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Busca todos os documentos de um projeto específico, com opção de filtro por tipo
     * 
     * @param string $projectId O ID do projeto
     * @param string|null $doc_type O tipo de documento para filtrar (opcional)
     * @return array Um array com todos os documentos do projeto que correspondem ao filtro
     */
    public static function getAllByProjectId($projectId, $doc_type = null)
    {
        $db = Database::getInstance();
        
        $sql = "SELECT * FROM documentation WHERE project_id = :projectId";
        $params = [":projectId" => $projectId];
        
        // Se um tipo específico for fornecido, adiciona-o à consulta SQL
        if ($doc_type && $doc_type !== 'All') {
            $sql .= " AND doc_type = :doc_type";
            $params[":doc_type"] = $doc_type;
        }
            
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll();
    }

    /**
     * Exclui um documento do sistema
     * 
     * @param string $id O ID do documento a ser excluído
     * @return bool Retorna true se a exclusão for bem-sucedida
     */
    public static function delete(string $id): bool{
        $db = Database::getInstance();
        $stmt = $db->prepare("
            DELETE FROM documentation 
            WHERE id = :id;
        ");
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}