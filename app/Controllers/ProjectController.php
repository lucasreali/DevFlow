<?php

namespace App\Controllers;

use App\Models\Project;

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
        $errors = [];
        if (empty($userId)) {
            $errors[] = 'User not logged in';
        }
        if (empty($name)) {
            $errors[] = 'Project name cannot be empty';
        }
        if (empty($description)) {
            $errors[] = 'Project description cannot be empty';
        }
        
        // Handle validation errors
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: /');
            exit;
        }

        $projectId = Project::create($userId, $name, $description);

        if ($projectId === false) {
            $_SESSION['errors'] = ['Failed to create project'];
            header('Location: /');
            exit;
        }

        header('Location: /');
    }

    public static function update($data) {
        $projectId = $data['projectId'] ?? null;
        $name = $_POST['name'] ?? null;
        $description = $_POST['description'] ?? null;

        // Validate all required parameters
        $errors = [];
        if (empty($projectId)) {
            $errors[] = 'Project ID cannot be empty';
        }
        if (empty($name)) {
            $errors[] = 'Project name cannot be empty';
        }
        if (empty($description)) {
            $errors[] = 'Project description cannot be empty';
        }
        
        // Handle validation errors
        if (!empty($errors)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = $errors;
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

        $project = Project::update($projectId, $name, $description);

        if ($project === false) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = ['Failed to update project'];
            header('Location: /');
            exit;
        }

        header('Location: /');
    }

    public static function delete($data) {
        $projectId = $data['projectId'] ?? null;

        // Validate all required parameters
        $errors = [];
        if (empty($projectId)) {
            $errors[] = 'Project ID cannot be empty';
        }
        
        // Handle validation errors
        if (!empty($errors)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = $errors;
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

        Project::delete($projectId);

        header('Location: /');
    }
}