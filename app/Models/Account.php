<?php

namespace App\Models;

use Core\Database;
use PDO;

class Account
{
    // Busca conta pelo github_id
    public static function findByGithubId($githubId)
    {
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare('SELECT * FROM accounts WHERE github_id = :github_id');
            $stmt->execute(['github_id' => $githubId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }

    // Busca conta pelo user_id
    public static function findByUserId($userId)
    {
        try {
            $db = Database::getInstance();
            $stmt = $db->prepare('SELECT * FROM accounts WHERE user_id = :user_id');
            $stmt->execute(['user_id' => $userId]);
            $account = $stmt->fetch(PDO::FETCH_ASSOC);
            return $account ?: null;
        } catch (\PDOException $e) {
            error_log('Database error: ' . $e->getMessage());
            return false;
        }
    }

    // Atualiza conta pelo github_id
    public static function updateByGithubId($githubId, $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE accounts
            SET 
                username = :username,
                avatar_url = :avatar_url,
                access_token = :access_token
            WHERE github_id = :github_id
        ');
        return $stmt->execute([
            'username' => $data['username'],
            'avatar_url' => $data['avatar_url'],
            'access_token' => $data['access_token'],
            'github_id' => $githubId,
        ]);
    }

    // Atualiza conta pelo user_id
    public static function updateByUserId($userId, $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE accounts
            SET 
                username = :username,
                avatar_url = :avatar_url,
                access_token = :access_token
            WHERE user_id = :user_id
        ');
        return $stmt->execute([
            'username' => $data['username'],
            'avatar_url' => $data['avatar_url'],
            'access_token' => $data['access_token'],
            'user_id' => $userId,
        ]);
    }

    // Cria uma nova conta
    public static function create($data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            INSERT INTO accounts (user_id, username, avatar_url, access_token, github_id)
            VALUES (:user_id, :username, :avatar_url, :access_token, :github_id)
        ');
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'username' => $data['username'],
            'avatar_url' => $data['avatar_url'],
            'access_token' => $data['access_token'],
            'github_id' => $data['github_id'],
        ]);
    }
}
