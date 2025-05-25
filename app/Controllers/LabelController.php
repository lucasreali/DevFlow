<?php

namespace App\Controllers;

use App\Models\Label;
use function Core\redirect;

class LabelController {

    public function store($data) {
        $title = $_POST['title'] ?? null;
        $color = $_POST['color'] ?? null;
        $projectId = $data['projectId'] ?? null;

        // Validate all required parameters
        if (empty($title)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Label title cannot be empty']);
        }
        if (empty($color)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Label color cannot be empty']);
        }
        if (empty($projectId)) {
            return redirect('/', ['error' => 'Project ID cannot be empty']);
        }

        $allowedColors = ['red', 'green', 'blue', 'yellow', 'purple', 'orange'];

        if (!in_array($color, $allowedColors)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Invalid color']);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        Label::create($title, $color, $projectId);

        return redirect('/dashboard/' . $projectId, ['success' => 'Label created successfully']);
    } 

    public function update($data) {
        $projectId = $data['projectId'] ?? null;
        $labelId = $_POST['label_id'] ?? null;
        $title = $_POST['title'] ?? null;
        $color = $_POST['color'] ?? null;

        // Validate all required parameters
        if (empty($labelId)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Label ID cannot be empty']);
        }
        if (empty($title)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Label title cannot be empty']);
        }
        if (empty($color)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Label color cannot be empty']);
        }
        if (empty($projectId)) {
            return redirect('/', ['error' => 'Project ID cannot be empty']);
        }

        $allowedColors = ['red', 'green', 'blue', 'yellow', 'purple', 'orange'];
        if (!in_array($color, $allowedColors)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Invalid color']);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        if (Label::update($labelId, $title, $color)) {
            return redirect('/dashboard/' . $projectId, ['success' => 'Label updated successfully']);
        } else {
            return redirect('/dashboard/' . $projectId, ['error' => 'Failed to update label']);
        }
    }

    public function delete($data) {
        $projectId = $data['projectId'] ?? null;
        $labelId = $_POST['label_id'] ?? null;
        
        // Validate all required parameters
        if (empty($labelId)) {
            return redirect('/dashboard/' . $projectId, ['error' => 'Label ID cannot be empty']);
        }
        if (empty($projectId)) {
            return redirect('/', ['error' => 'Project ID cannot be empty']);
        }

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            return redirect('/login', ['error' => 'User not logged in']);
        }

        if (Label::delete($labelId)) {
            return redirect('/dashboard/' . $projectId, ['success' => 'Label deleted successfully']);
        } else {
            return redirect('/dashboard/' . $projectId, ['error' => 'Failed to delete label']);
        }
    }
}

?>