<?php

namespace App\Controllers;

use Core\Database;
use PDO;

class AccountController
{
    public static function store($user, $accessToken)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare('SELECT * FROM accounts WHERE id = :id');
        $stmt->execute(['id' => $user['id']]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        try {
            if ($account) {
                $stmt = $db->prepare('UPDATE accounts SET access_token = :access_token, avatar_url = :avatar_url WHERE id = :id');
                $stmt->execute([
                    'access_token' => $accessToken,
                    'avatar_url' => $user['avatar_url'],
                    'id' => $user['id']
                ]);
            } else {

                $stmt = $db->prepare('INSERT INTO users (username) VALUES (:username)');
                $stmt->execute([
                    'username' => $user['login']
                ]);
                $userId = $db->lastInsertId();

                $stmt = $db->prepare('INSERT INTO accounts (id, avatar_url, access_token, user_id) VALUES (:id, :avatar_url, :access_token, :user_id)');
                $stmt->execute([
                    'id' => $user['id'],
                    'avatar_url' => $user['avatar_url'],
                    'access_token' => $accessToken,
                    'user_id' => $userId
                ]);
            }

            session_start();
            $_SESSION['user'] = $user;

        } catch (\PDOException $e) {
            die('Erro ao salvar a conta: ' . $e->getMessage());
        }
    }
}
