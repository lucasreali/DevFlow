<?php

namespace App\Controllers;

use App\Models\Label;

class LabelController {

    public function store() {

        $userId = $_GET['user_id'];
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

        Label::create(userId : $userId, title : $title, color: $color);
    } 

    public function update() {
        $userId = $_GET['user_id'];
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

        Label::updateByUserId($userId, $title, $color);
    }


    public function findByUserId() {
        $userId = $_GET['user_id'];

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $userId = $_SESSION['user']['id'];

        echo $userId;

        if ($userId === null) {
            throw new \RuntimeException('User not logged in');
        }

        Label::findByUserId($userId);
    }
}

?>