<?php

namespace App\Controllers;

use App\Models\Project;
use App\Services\GitHubService;
use function Core\redirect;

class ProjectController
{
    public function store($data)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user']['id'] ?? null;
        $name = $data['name'] ?? null;
        $description = $data['description'] ?? null;

        // Validate all required parameters
        if (empty($userId)) {
            return redirect('/', ['error' => 'User not logged in']);
        }
        if (empty($name)) {
            return redirect('/', ['error' => 'Project name cannot be empty']);
        }
        if (empty($description)) {
            return redirect('/', ['error' => 'Project description cannot be empty']);
        }

        $projectId = Project::create($userId, $name, $description);

        if ($projectId === false) {
            return redirect('/', ['error' => 'Failed to create project']);
        }

        return redirect('/', ['success' => 'Project created successfully']);
    }

    public static function update($data) {
        $projectId = $data['projectId'] ?? null;
        $name = $data['name'] ?? null;
        $description = $data['description'] ?? null;

        // Validate all required parameters
        if (empty($projectId)) {
            return redirect('/', ['error' => 'Project ID cannot be empty']);
        }
        if (empty($name)) {
            return redirect('/', ['error' => 'Project name cannot be empty']);
        }
        if (empty($description)) {
            return redirect('/', ['error' => 'Project description cannot be empty']);
        }

        $project = Project::getById($projectId);
        if (!$project) {
            return redirect('/', ['error' => 'Project not found']);
        }

        $project = Project::update($projectId, $name, $description);

        if ($project === false) {
            return redirect('/', ['error' => 'Failed to update project']);
        }

        return redirect('/', ['success' => 'Project updated successfully']);
    }

    public static function delete($data) {
        $projectId = $data['projectId'] ?? null;

        // Validate all required parameters
        if (empty($projectId)) {
            return redirect('/', ['error' => 'Project ID cannot be empty']);
        }

        $project = Project::getById($projectId);
        if (!$project) {
            return redirect('/', ['error' => 'Project not found']);
        }

        Project::delete($projectId);

        return redirect('/', ['success' => 'Project deleted successfully']);
    }

    public static function setGitHubProject($data) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $githubProject = $data['github_project'] ?? null;
        $githubOwner = $data['github_owner'] ?? null;
        $projectId = $data['project_id'] ?? null;
        $userId = $_SESSION['user']['id'] ?? null;

        // Validate required parameters
        if (empty($projectId)) {
            return redirect('/', ['error' => 'Project ID cannot be empty']);
        }

        if (empty($githubProject)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'GitHub project cannot be empty']);
        }
        
        if (empty($userId)) {
            return redirect('/', ['error' => 'User not logged in']);
        }

        try {
            // Check if project exists
            $project = Project::getById($projectId);
            if (!$project) {
                return redirect('/', ['error' => 'Project not found']);
            }
            
            // Verify user owns this project
            if ($project['user_id'] != $userId) {
                return redirect('/', ['error' => 'You do not have permission to update this project']);
            }
            
            // Check if GitHub project is already used in another project by the same user
            $existingProject = Project::getByGitHubProject($githubProject, $userId, $projectId);
            if ($existingProject) {
                return redirect('/dashboard/' . $projectId, [
                    'error' => 'This GitHub project is already linked to your project: ' . $existingProject['name']
                ]);
            }

            // If no owner provided, get repo owner info from GitHub
            if (empty($githubOwner)) {
                $repoInfo = GitHubService::getRepoOwnerInfo($githubProject);
                if ($repoInfo) {
                    $githubOwner = $repoInfo['owner'];
                } else {
                    $githubOwner = $_SESSION['user']['username']; // Default to current user
                }
            }

            // Update the GitHub project with owner information
            $result = Project::setGitHubProject($projectId, $githubProject, $githubOwner);
            
            if ($result === false) {
                return redirect('/dashboard/' . $projectId, ['error' => 'Failed to update GitHub project']);
            }
            
            return redirect('/dashboard/' . $projectId, ['success' => 'GitHub project set successfully!']);
        } catch (\Exception $e) {
            // Log the error if you have a logging system
            error_log('Error setting GitHub project: ' . $e->getMessage());
            
            return redirect('/dashboard/' . $projectId, ['error' => 'An error occurred while setting the GitHub project: ' . $e->getMessage()]);
        }
    }

    public static function addGitHubParticipant($projectId, $username)
    {
        // Obter informações do projeto
        $project = Project::getById($projectId);
        
        if (!$project || empty($project['github_project'])) {
            return false;
        }
        
        // Verificar se o usuário participa do repositório
        $isParticipant = GitHubService::isUserRepositoryCollaborator(
            $project['github_project'],
            $username,
            $project['github_project_owner']
        );
        
        if ($isParticipant) {
            // Buscar ID do usuário pelo nome de usuário do GitHub
            $account = \App\Models\Account::findByUsername($username);
            
            if ($account) {
                // Adicionar à tabela de participantes
                return Project::addProjectMember($account['user_id'], $projectId);
            }
        }
        
        return false;
    }
}