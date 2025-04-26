<?php

namespace App\Controllers;

use App\Models\Board;
use App\Models\Project;
use App\Models\Task;
use function Core\view;

class PageController
{
    /**
     * Exibe a página inicial.
     *
     * @param array $params Parâmetros da rota.
     * @return string Renderização da view.
     */
    public static function home(array $params)
    {
        $user = $_SESSION['user'] ?? null;
        $number = $params['number'] ?? null;

        return view('home', [
            'user' => $user,
            'number' => $number,
        ]);
    }

    public static function dashboard(array $params)
    {   
        $projectId = $params['projectId'] ?? null;

        $boards = Board::getAll($projectId);

        foreach ($boards as &$board) {
            $board['tasks'] = Task::getAllByBoardId($board['id']);
        }

        $project = Project::getById($projectId);

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
        ]);
    }

    public static function login()
    {
        return view('auth/login');
    }
    
    public static function register()
    {
        return view('auth/register');
    }
}