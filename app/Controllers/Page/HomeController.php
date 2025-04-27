<?php

namespace App\Controllers\Page;

use App\Models\Project;
use function Core\view;

class HomeController
{
    public static function index(array $data)
    {
        $user = $_SESSION['user'] ?? null;

        $projects = Project::getAll($user['id']);

        return view('home', [
            'user' => $user,
            'projects' => $projects,
        ]);
    }
}