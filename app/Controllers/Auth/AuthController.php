<?php

namespace App\Controllers\Auth;

class AuthController
{
    public static function github()
    {
        $clientId = $_ENV['GITHUB_CLIENT_ID'];
        $redirectUri = $_ENV['GITHUB_REDIRECT_URI'];

        $githubAuthUrl = "https://github.com/login/oauth/authorize?client_id={$clientId}&redirect_uri={$redirectUri}&scope=user";

        header("Location: $githubAuthUrl");
        exit;
    }

    public static function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /');
        exit;
    }
}
