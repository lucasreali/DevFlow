<?php

namespace App\Controllers\Page;

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
        
        $userId = $_SESSION['user']['id'] ?? null;
        
        if (!$userId) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        if ($project['user_id'] !== $userId) {
            return redirect('/', ['error' => 'You do not have access to this project']);
        }
        
        $labels = Label::getByProjectId($projectId);
        $availableLabels = Label::getAllByProjectId($projectId);
        
        $boards = Board::getAll($projectId);
        
        foreach ($boards as &$board) {
            $board['tasks'] = Task::getAllByBoardId($board['id']);
        }

        $dataOtherProjects = Project::getAll($_SESSION['user']['id']);

        $otherProjects = [];
        foreach ($dataOtherProjects as $dataProject) {
            $otherProjects[] = [
            'name' => $dataProject['name'] ?? null,
            'id' => $dataProject['id'] ?? null,
            ];
        }

        if (!$project) {
            return view('dashboard', [
                'message' => 'Project not found.',
            ]);
        }

        if (!$project['github_project']) {
            $github_projects = GitHubService::getRepositories();
        } else {
            $commits = GitHubService::getCommits($project['github_project']);
            $contributors = GitHubService::getContributors($project['github_project']);
        }

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

            'error' => $params['error'] ?? null,
            'success' => $params['success'] ?? null,
        ]);
    }
}