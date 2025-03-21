<?php

namespace App\Middleware;

class GuestMiddleware
{
    public static function handle()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (isset($_SESSION['user'])) {
            header('Location: /dashboard');
            exit();
        }
    }
}
