<?php

namespace App\Models;

use App\Services\GitHubService;
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

    public static function addProjectMember($userId, $projectId)
    {
        $db = Database::getInstance();
        
        $checkStmt = $db->prepare('
            SELECT 1 FROM project_members 
            WHERE user_id = :user_id AND project_id = :project_id
        ');
        
        $checkStmt->execute([
            'user_id' => $userId,
            'project_id' => $projectId
        ]);
        
        if ($checkStmt->fetch()) {
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