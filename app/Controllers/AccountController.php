<?php

namespace App\Controllers;

use Core\Database;
use PDO;



class AccountController
{
    public static function store($user, $accessToken)
    {
        $db = Database::getInstance();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $stmt = $db->prepare('SELECT * FROM users WHERE github_id = :github_id');
            $stmt->execute(['github_id' => $user['id']]);
            $account = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($account) {
                $stmt = $db->prepare('UPDATE users 
                    SET access_token = :access_token, avatar_url = :avatar_url 
                    WHERE github_id = :github_id');
                $stmt->execute([
                    'access_token' => $accessToken,
                    'avatar_url' => $user['avatar_url'],
                    'github_id' => $user['id']
                ]);
            } else {
                $stmt = $db->prepare('INSERT INTO users (nickname, avatar_url, access_token, github_id) 
                    VALUES (:nickname, :avatar_url, :access_token, :github_id)');
                $stmt->execute([
                    'nickname' => $user['login'],
                    'avatar_url' => $user['avatar_url'],
                    'access_token' => $accessToken,
                    'github_id' => $user['id']
                ]);
            }

            $_SESSION['user'] = [
                'id' => $user['id'],
                'nickname' => $user['login'],
                'avatar_url' => $user['avatar_url'],
                'access_token' => $accessToken
            ];

        } catch (\PDOException $e) {
            error_log('Erro ao salvar a conta: ' . $e->getMessage());
            header('Location: /error');
            exit;
        }
    }
}
