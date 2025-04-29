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
    
        $project = Project::getById($projectId);

        $userId = $_SESSION['user']['id'] ?? null;

        if ($project['user_id'] !== $userId) {
            header('Location: /');
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