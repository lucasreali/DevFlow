<?php

namespace App\Middleware;

class AuthMiddleware
{
    public static function handle()
    {

        if (!isset($_SESSION)) {
            header('Location: /');
            exit;
        }
    }
}
