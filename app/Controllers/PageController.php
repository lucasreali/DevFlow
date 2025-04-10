<?php

namespace App\Controllers;

use App\Models\Board;
use function Core\view;

class PageController
{
    public static function home(array $params)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user = $_SESSION['user'] ?? null;

        $number = $params['number'] ?? null;

        return view('home', [
            'user' => $user,
            'number' => $number,
        ]);
    }

    public static function dashboard()
    {   

        $boards = Board::getAll(1);

        return view('dashboard', [
            'boards' => $boards,
        ]);
    }
}