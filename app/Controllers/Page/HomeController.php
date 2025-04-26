<?php

namespace App\Controllers\Page;

use function Core\view;

class HomeController
{
    public static function index(array $params)
    {
        $user = $_SESSION['user'] ?? null;
        $number = $params['number'] ?? null;

        return view('home', [
            'user' => $user,
            'number' => $number,
        ]);
    }
}