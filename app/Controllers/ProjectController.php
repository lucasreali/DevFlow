<?php

namespace App\Controllers;

use App\Models\Project;

class ProjectController
{
    public function store()
    {
        $userId = $_SESSION['user']['id'] ?? null;
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;

        if (empty($userId)) {
            throw new \RuntimeException('User not logged in');
        }

        if (empty($name)) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }

        if (empty($description)) {
            throw new \InvalidArgumentException('Description cannot be empty');
        }

        $projectId = Project::create($userId, $name, $description);

        if ($projectId === false) {
            throw new \RuntimeException('Failed to create project');
        }

        header('Location: /');
    }

    public static function update($data) {
        $projectId = $data['projectId'] ?? null;
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;

        if (empty($projectId)) {
            throw new \InvalidArgumentException('Project ID cannot be empty');
        }

        if (empty($name)) {
            throw new \InvalidArgumentException('Name cannot be empty');
        }

        if (empty($description)) {
            throw new \InvalidArgumentException('Description cannot be empty');
        }

        $project = Project::getById($projectId);
        if (!$project) {
            throw new \RuntimeException('Project not found');
        }

        $project = Project::update($projectId, $name, $description);

        if ($project === false) {
            throw new \RuntimeException('Failed to update project');
        }

        header('Location: /');
    }

    public static function delete($data) {
        $projectId = $data['projectId'] ?? null;

        if (empty($projectId)) {
            throw new \InvalidArgumentException('Project ID cannot be empty');
        }

        $project = Project::getById($projectId);
        if (!$project) {
            throw new \RuntimeException('Project not found');
        }

        Project::delete($projectId);

        header('Location: /');
    }
}