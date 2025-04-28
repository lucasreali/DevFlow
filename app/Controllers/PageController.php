<?php

namespace App\Controllers;

use App\Models\Board;
use function Core\view;

class PageController
{
    /**
     * Exibe a página inicial.
     *
     * @param array $params Parâmetros da rota.
     * @return string Renderização da view.
     */
    public static function home(array $params)
    {
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

    public static function login()
    {
        return view('auth/login');
    }
    
    public static function register()
    {
        return view('auth/register');
    }
}