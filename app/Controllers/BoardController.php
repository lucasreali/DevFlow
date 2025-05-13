<?php

namespace App\Controllers;

use App\Models\Board;
use function Core\view;

class BoardController
{
    public function store($data) {

        $projectId = $data['projectId'] ?? null;
        $title = $data['title'] ?? null;
        $color = $data['color'] ?? null;

        // Validate all required parameters
        $errors = [];
        if (empty($projectId)) {
            $errors[] = 'Project ID cannot be empty';
        }
        if (empty($title)) {
            $errors[] = 'Board title cannot be empty';
        }
        if (empty($color)) {
            $errors[] = 'Board color cannot be empty';
        }

        if (!empty($errors)) {
            // Return with errors if validation fails
            $_SESSION['errors'] = $errors;
            header('Location: /dashboard/' . $projectId);
            exit;
        }

        $possibleColors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];

        if (!in_array($color, $possibleColors)) {
            $_SESSION['errors'] = ['Invalid color selected'];
            header('Location: /dashboard/' . $projectId);
            exit;
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'];

        if ($userId === null) {
            $_SESSION['errors'] = ['User not logged in'];
            header('Location: /login');
            exit;
        }

        $boards = Board::getAll($projectId);
        $position = count($boards) + 1;
            

        $boardId = Board::create($title,$color, $projectId, $position);

        if ($boardId === false) {
            throw new \RuntimeException('Failed to create board');
        }

        header('Location: /dashboard/' . $projectId);
        exit;
    }

    public function show() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'];

        if ($userId === null) {
            $_SESSION['errors'] = ['User not logged in'];
            header('Location: /login');
            exit;
        }

        $projectId = $_GET['project'] ?? null;
        
        if (empty($projectId)) {
            $_SESSION['errors'] = ['Project ID is required'];
            header('Location: /');
            exit;
        }

        $boards = Board::getAll($projectId);

        return view('dashboard', ['boards' => $boards]);
    }
}