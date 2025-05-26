<?php

namespace App\Controllers\Page;

use App\Controllers\ProjectController;
use App\Models\Board;
use App\Models\Label;
use App\Models\Project;
use App\Models\Task;
use App\Services\GitHubService;
use function Core\redirect;
use function Core\view;

class DashboardController
{
    public static function index(array $params)
    {   
        $projectId = $params['projectId'] ?? null;
        
        // Validate all required parameters
        if (empty($projectId)) {
            return redirect('/', ['error' => 'Project ID is required']);
        }
    
        $project = Project::getById($projectId);
        
        if (!$project) {
            return redirect('/', ['error' => 'Project not found']);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $user = $_SESSION['user'] ?? null;
        
        if (!$user['id']) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        // Verificar se o usuário é dono do projeto
        $isOwner = ($project['user_id'] == $user['id']);

        // Se não for dono, verificar se é membro
        $isMember = false;
        if (!$isOwner) {
            // Verificar na tabela project_members
            $isMember = Project::isProjectMember($user['id'], $projectId);
            
            // Se não for membro, verificar se participa no GitHub e adicionar
            if (!$isMember && isset($user['username']) && !empty($user['access_token']) && !empty($project['github_project'])) {
                $addedAsMember = ProjectController::addGitHubParticipant($projectId, $user['username']);
                $isMember = $addedAsMember;
            }
        }

        // Se não for dono nem membro, negar acesso
        if (!$isOwner && !$isMember) {
            return redirect('/', ['error' => 'You do not have access to this project']);
        }
        
        $labels = Label::getByProjectId($projectId);
        $availableLabels = Label::getAllByProjectId($projectId);
        
        $boards = Board::getAll($projectId);
        
        foreach ($boards as &$board) {
            $board['tasks'] = Task::getAllByBoardId($board['id']);
        }

        // Obter todos os projetos que o usuário criou
        $dataOtherProjects = Project::getAll($user['id']);

        $otherProjects = [];
        foreach ($dataOtherProjects as $dataProject) {
            $otherProjects[] = [
            'name' => $dataProject['name'] ?? null,
            'id' => $dataProject['id'] ?? null,
            ];
        }

        if (!$project['github_project']) {
            $github_projects = GitHubService::getParticipatingRepositories();
        } else {
            $commits = GitHubService::getCommits($project['github_project'], $project['github_project_owner']);
            $contributors = GitHubService::getContributors($project['github_project'], $project['github_project_owner']);
        }

        // Obter membros do projeto
        $projectMembers = Project::getProjectMembers($projectId);

        return view('dashboard', [
            'project' => $project,
            'boards' => $boards,
            'otherProjects' => $otherProjects,
            'page' => 'boards',
            'labels' => $labels,
            'availableLabels' => $availableLabels,
            'github_projects' => $github_projects ?? null,
            'commits' => $commits ?? null,
            'contributors' => $contributors ?? null,
            'projectMembers' => $projectMembers,
            'error' => $params['error'] ?? null,
            'success' => $params['success'] ?? null,
            'isOwner' => $isOwner,
            'isMember' => $isMember,
        ]);
    }
}