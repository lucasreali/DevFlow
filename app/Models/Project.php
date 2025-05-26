<?php

namespace App\Models;

use Core\Database;

class Project
{
    public static function create($userId, $name, $description) {

        $db = Database::getInstance();
        $stmt = $db->prepare('
            INSERT INTO projects (user_id, name, description)
            VALUES (:user_id, :name, :description)
        ');

        $stmt->execute([
            'user_id' => $userId,
            'name' => $name,
            'description' => $description,
        ]);

        return $db->lastInsertId();
    }

    public static function getAll($userId) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT * FROM projects WHERE user_id = :user_id
        ');

        $stmt->execute([
            'user_id' => $userId,
        ]);
        return $stmt->fetchAll();
    }

    public static function getById($projectId) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT * FROM projects WHERE id = :project_id
        ');

        $stmt->execute([
            'project_id' => $projectId,
        ]);
        return $stmt->fetch();
    }

    public static function update($projectId, $name, $description) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE projects 
            SET name = :name, description = :description 
            WHERE id = :project_id
        ');

        return $stmt->execute([
            'project_id' => $projectId,
            'name' => $name,
            'description' => $description,
        ]);
    }

    public static function delete($projectId) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            DELETE FROM projects WHERE id = :project_id
        ');

        return $stmt->execute([
            'project_id' => $projectId,
        ]);
    }

    public static function setGitHubProject($projectId, $githubProject, $githubOwner = null) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE projects 
            SET github_project = :github_project,
                github_project_owner = :github_owner 
            WHERE id = :project_id
        ');

        return $stmt->execute([
            'project_id' => $projectId,
            'github_project' => $githubProject,
            'github_owner' => $githubOwner,
        ]);
    }

    public static function getByGitHubProject($githubProject, $userId, $excludeProjectId = null) {
        $db = Database::getInstance();
        $sql = 'SELECT * FROM projects 
                WHERE github_project = :github_project 
                AND user_id = :user_id';
        
        if ($excludeProjectId !== null) {
            $sql .= ' AND id != :exclude_project_id';
        }
        
        $stmt = $db->prepare($sql);
        
        $params = [
            'github_project' => $githubProject,
            'user_id' => $userId
        ];
        
        if ($excludeProjectId !== null) {
            $params['exclude_project_id'] = $excludeProjectId;
        }
        
        $stmt->execute($params);
        return $stmt->fetch();
    }

    /**
     * Busca projetos por nome de repositório GitHub
     * 
     * @param string $githubProject Nome do repositório GitHub
     * @return array Projetos encontrados
     */
    public static function findByGitHubProject($githubProject) {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT * FROM projects 
            WHERE github_project = :github_project
        ');
        
        $stmt->execute([
            'github_project' => $githubProject
        ]);
        
        return $stmt->fetchAll();
    }

    /**
     * Verifica se um usuário é membro do projeto
     * 
     * @param int $userId ID do usuário
     * @param int $projectId ID do projeto
     * @return bool True se for membro, false caso contrário
     */
    public static function isProjectMember($userId, $projectId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT 1 FROM project_members 
            WHERE user_id = :user_id AND project_id = :project_id
        ');
        
        $stmt->execute([
            'user_id' => $userId,
            'project_id' => $projectId
        ]);
        
        return (bool) $stmt->fetch();
    }
    

    public static function addGitHubParticipant($projectId, $username)
    {
        // Obter informações do projeto
        $project = self::getById($projectId);
        
        if (!$project || empty($project['github_project'])) {
            return false;
        }
        
        // Verificar se o usuário participa do repositório
        $isParticipant = \App\Services\GitHubService::isUserRepositoryCollaborator(
            $project['github_project'],
            $username,
            $project['github_project_owner']
        );
        
        if ($isParticipant) {
            // Buscar ID do usuário pelo nome de usuário do GitHub
            $account = \App\Models\Account::findByUsername($username);
            
            if ($account) {
                // Adicionar à tabela de participantes
                return self::addProjectMember($account['user_id'], $projectId);
            }
        }
        
        return false;
    }
    
    /**
     * Adiciona um usuário como membro de um projeto
     * 
     * @param int $userId ID do usuário
     * @param int $projectId ID do projeto
     * @return bool Resultado da operação
     */
    public static function addProjectMember($userId, $projectId)
    {
        $db = Database::getInstance();
        
        // Verificar se já é membro
        $checkStmt = $db->prepare('
            SELECT 1 FROM project_members 
            WHERE user_id = :user_id AND project_id = :project_id
        ');
        
        $checkStmt->execute([
            'user_id' => $userId,
            'project_id' => $projectId
        ]);
        
        if ($checkStmt->fetch()) {
            // Já é membro
            return true;
        }
        
        // Adicionar como membro
        $stmt = $db->prepare('
            INSERT INTO project_members (user_id, project_id)
            VALUES (:user_id, :project_id)
        ');
        
        return $stmt->execute([
            'user_id' => $userId,
            'project_id' => $projectId
        ]);
    }
    
    /**
     * Obtém todos os membros de um projeto
     * 
     * @param int $projectId ID do projeto
     * @return array Lista de membros
     */
    public static function getProjectMembers($projectId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            SELECT u.id, u.name, u.email, a.username, a.avatar_url 
            FROM project_members pm
            JOIN users u ON pm.user_id = u.id
            LEFT JOIN accounts a ON u.id = a.user_id
            WHERE pm.project_id = :project_id
        ');
        
        $stmt->execute([
            'project_id' => $projectId
        ]);
        
        return $stmt->fetchAll();
    }
}