<?php

namespace App\Controllers;

use App\Models\Board;

class BoardController
{
    public function store() {

        $projectId = $_GET['project'];
        $title = $_POST['title'];
        $color = $_POST['color'];

        $allowedColors = ['red', 'green', 'blue', 'yellow', 'purple'];
        if (!in_array($color, $allowedColors)) {
            throw new \InvalidArgumentException('Invalid color');
        }

        if (empty($title)) {
            throw new \InvalidArgumentException('Title cannot be empty');
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'];

        echo $userId;

        if ($userId === null) {
            throw new \RuntimeException('User not logged in');
        }

        Board::create($userId,$title,$color, $projectId);
    }
}