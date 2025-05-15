<?php

namespace App\Controllers;

use App\Models\Board;
use function Core\view;
use function Core\redirect;

class BoardController
{
    public function store($data) {

        $projectId = $data['projectId'] ?? null;
        $title = $data['title'] ?? null;
        $color = $data['color'] ?? null;

        // Validate all required parameters
        $errors = [];
        if (empty($projectId)) {
            return redirect('/', ['error' => 'Project ID cannot be empty']);
        }
        if (empty($title)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Board title cannot be empty']);
        }
        if (empty($color)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Board color cannot be empty']);
        }

        $possibleColors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];

        if (!in_array($color, $possibleColors)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Invalid color selected']);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'];

        if ($userId === null) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        $boards = Board::getAll($projectId);
        $position = count($boards) + 1;
            
        $boardId = Board::create($title,$color, $projectId, $position);

        if ($boardId === false) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Failed to create board']);
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
            return redirect('/login', ['error' => 'User not logged in']);
        }

        $projectId = $_GET['project'] ?? null;
        
        if (empty($projectId)) {
            return redirect('/', ['error' => 'Project ID is required']);
        }

        $boards = Board::getAll($projectId);

        return view('dashboard', ['boards' => $boards]);
    }
}