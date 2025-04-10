<?php

namespace App\Controllers;

use App\Models\Board;
use function Core\view;

class BoardController
{
    public function store($params) {

        $projectId = $params['projectId'] ?? null;
        $title = $_POST['title'];
        $color = $_POST['color'];

        if (empty($projectId)) {
            throw new \InvalidArgumentException('Project ID cannot be empty');
        }
        if (empty($color)) {
            throw new \InvalidArgumentException('Color cannot be empty');
        }

        if (empty($title)) {
            throw new \InvalidArgumentException('Title cannot be empty');
        }

        $possibleColors = ['red', 'blue', 'green', 'yellow', 'purple', 'orange'];

        if (!in_array($color, $possibleColors)) {
            throw new \InvalidArgumentException('Invalid color');
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'];


        if ($userId === null) {
            throw new \RuntimeException('User not logged in');
        }

        $boards = Board::getAll($projectId);
        foreach ($boards as $board) {
            if ($board['title'] === $title) {
                throw new \RuntimeException('Board with this title already exists');
            }
        }

        $position = count($boards) + 1;
            

        $boardId = Board::create($title,$color, $projectId, $position);

        if ($boardId === false) {
            throw new \RuntimeException('Failed to create board');
        }
        header('Location: /dashboard');
        exit;
    }

    public function show() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'];

        if ($userId === null) {
            throw new \RuntimeException('User not logged in');
        }

        $projectId = $_GET['project'];

        $boards = Board::getAll($projectId);

        return view('dashboard', ['boards' => $boards]);
    }
}