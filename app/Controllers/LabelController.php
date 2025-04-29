<?php

namespace App\Controllers;

use App\Models\Label;

class LabelController {

    public function store($data) {

        $title = $_POST['title'];
        $color = $_POST['color'];

        $projectId = $data['projectId'];

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

        if ($userId === null) {
            throw new \RuntimeException('User not logged in');
        }

        Label::create($title,$color, $projectId);

        header('Location: /dashboard/' . $projectId);
    } 

    public function update($data) {
        $projectId = $data['projectId'];
        $labelId = $_POST['label_id'] ?? null;
        $title = $_POST['title'] ?? '';
        $color = $_POST['color'] ?? '';

        if (!$labelId) {
            throw new \InvalidArgumentException('Label ID is required');
        }

        $allowedColors = ['red', 'green', 'blue', 'yellow', 'purple', 'orange'];
        if (!in_array($color, $allowedColors)) {
            throw new \InvalidArgumentException('Invalid color');
        }

        if (empty($title)) {
            throw new \InvalidArgumentException('Title cannot be empty');
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            throw new \RuntimeException('User not logged in');
        }

        if (Label::update($labelId, $title, $color)) {
            header('Location: /dashboard/' . $projectId);
            exit;
        } else {
            throw new \RuntimeException('Failed to update label');
        }
    }

    public function delete($data) {
        $projectId = $data['projectId'];
        $labelId = $_POST['label_id'] ?? null;

        if (!$labelId) {
            throw new \InvalidArgumentException('Label ID is required');
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            throw new \RuntimeException('User not logged in');
        }

        if (Label::delete($labelId)) {
            header('Location: /dashboard/' . $projectId);
            exit;
        } else {
            throw new \RuntimeException('Failed to delete label');
        }
    }
}

?>