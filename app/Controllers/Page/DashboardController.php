<?php

namespace App\Controllers\Page;

use App\Models\Board;
use App\Models\Label;
use App\Models\Project;
use App\Models\Task;
use function Core\view;

class DashboardController
{
    public static function index(array $params)
    {   
        $projectId = $params['projectId'] ?? null;
        
        // Validate all required parameters
        if (empty($projectId)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = ['Project ID is required'];
            header('Location: /');
            exit;
        }
    
        $project = Project::getById($projectId);
        
        if (!$project) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = ['Project not found'];
            header('Location: /');
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        $userId = $_SESSION['user']['id'] ?? null;
        
        if (!$userId) {
            $_SESSION['errors'] = ['User not logged in'];
            header('Location: /login');
            exit;
        }

        if ($project['user_id'] !== $userId) {
            $_SESSION['errors'] = ['You do not have access to this project'];
            header('Location: /');
            exit;
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

        return view('dashboard', [
            'project' => $project,
            'boards' => $boards,
            'otherProjects' => $otherProjects,
            'page' => 'boards',
            'labels' => $labels,
            'availableLabels' => $availableLabels,
        ]);
    }
}