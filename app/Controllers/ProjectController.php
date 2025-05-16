<?php

namespace App\Controllers;

use App\Models\Project;
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

        header('Location: /');
        exit;
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

        header('Location: /');
        exit;
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

        header('Location: /');
        exit;
    }
}