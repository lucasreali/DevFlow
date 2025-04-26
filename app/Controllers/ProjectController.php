<?php

namespace App\Controllers;

use App\Models\Project;

class ProjectController
{
    public function store()
    {
        $userId = $_SESSION['user']['id'] ?? null;
        $name = $_POST['name'] ?? null;

        if (empty($userId)) {
            throw new \RuntimeException('User not logged in');
        }

        if (empty($name)) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }

        $projectId = Project::create($userId, $name);

        if ($projectId === false) {
            throw new \RuntimeException('Failed to create project');
        }

        header('Location: /dashboard/' . $projectId);
    }
}