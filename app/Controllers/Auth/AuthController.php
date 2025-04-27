<?php

namespace App\Controllers\Auth;

use function Core\view;

class AuthController
{
    public static function github()
{
    $clientId = $_ENV['GITHUB_CLIENT_ID'];
    $redirectUri = $_ENV['GITHUB_REDIRECT_URI'];

    $scopes = 'user repo';

    $githubAuthUrl = "https://github.com/login/oauth/authorize?client_id={$clientId}&redirect_uri={$redirectUri}&scope={$scopes}";

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

    public static function setUserSession($user)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user'] = [
            'id' => $user['id'] ?? null,
            'name' => $user['name'] ?? null,
            'github_id' => $user['github_id'] ?? null,
            'username' => $user['username'] ?? null,
            'email' => $user['email'] ?? null,
            'avatar_url' => $user['avatar_url'] ?? null,
            'access_token' => $user['access_token'] ?? null,
        ];
    }

    public static function login($data)
    {
        $success = $data['success'] ?? null;
        return view('auth/login', ['success' => $success]);
    }
    
    public static function register()
    {
        return view('auth/register');
    }
}
