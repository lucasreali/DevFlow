<?php

namespace App\Controllers;

use App\Models\Label;

class LabelController {

    public function store($data) {
        $title = $_POST['title'] ?? null;
        $color = $_POST['color'] ?? null;
        $projectId = $data['projectId'] ?? null;

        // Validate all required parameters
        $errors = [];
        if (empty($title)) {
            $errors[] = 'Label title cannot be empty';
        }
        if (empty($color)) {
            $errors[] = 'Label color cannot be empty';
        }
        if (empty($projectId)) {
            $errors[] = 'Project ID cannot be empty';
        }
        
        // Handle validation errors
        if (!empty($errors)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = $errors;
            
            if (!empty($projectId)) {
                header('Location: /dashboard/' . $projectId);
                exit;
            } else {
                header('Location: /');
                exit;
            }
        }

        $allowedColors = ['red', 'green', 'blue', 'yellow', 'purple', 'orange'];

        if (!in_array($color, $allowedColors)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = ['Invalid color'];
            header('Location: /dashboard/' . $projectId);
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

        Label::create($title, $color, $projectId);

        header('Location: /dashboard/' . $projectId);
    } 

    public function update($data) {
        $projectId = $data['projectId'] ?? null;
        $labelId = $_POST['label_id'] ?? null;
        $title = $_POST['title'] ?? null;
        $color = $_POST['color'] ?? null;

        // Validate all required parameters
        $errors = [];
        if (empty($labelId)) {
            $errors[] = 'Label ID cannot be empty';
        }
        if (empty($title)) {
            $errors[] = 'Label title cannot be empty';
        }
        if (empty($color)) {
            $errors[] = 'Label color cannot be empty';
        }
        if (empty($projectId)) {
            $errors[] = 'Project ID cannot be empty';
        }
        
        // Handle validation errors
        if (!empty($errors)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = $errors;
            
            if (!empty($projectId)) {
                header('Location: /dashboard/' . $projectId);
                exit;
            } else {
                header('Location: /');
                exit;
            }
        }

        $allowedColors = ['red', 'green', 'blue', 'yellow', 'purple', 'orange'];
        if (!in_array($color, $allowedColors)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = ['Invalid color'];
            header('Location: /dashboard/' . $projectId);
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

        if (Label::update($labelId, $title, $color)) {
            header('Location: /dashboard/' . $projectId);
            exit;
        } else {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = ['Failed to update label'];
            header('Location: /dashboard/' . $projectId);
            exit;
        }
    }

    public function delete($data) {
        $projectId = $data['projectId'] ?? null;
        $labelId = $_POST['label_id'] ?? null;
        
        // Validate all required parameters
        $errors = [];
        if (empty($labelId)) {
            $errors[] = 'Label ID cannot be empty';
        }
        if (empty($projectId)) {
            $errors[] = 'Project ID cannot be empty';
        }
        
        // Handle validation errors
        if (!empty($errors)) {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['errors'] = $errors;
            
            if (!empty($projectId)) {
                header('Location: /dashboard/' . $projectId);
                exit;
            } else {
                header('Location: /');
                exit;
            }
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

        if (Label::delete($labelId)) {
            header('Location: /dashboard/' . $projectId);
            exit;
        } else {
            $_SESSION['errors'] = ['Failed to delete label'];
            header('Location: /dashboard/' . $projectId);
            exit;
        }
    }
}

?>