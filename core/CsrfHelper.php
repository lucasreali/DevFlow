<?php
namespace Core;

class CsrfHelper
{
    public static function generateToken()
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }

    public static function validateToken($token)
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $isValid = isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);

        if ($isValid) {
            unset($_SESSION['csrf_token']); // Regenera o token após validação
        }

        return $isValid;
    }
}