<?php

namespace App\Helpers;

class SessionHelper
{
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
}
