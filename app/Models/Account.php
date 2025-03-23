<?php

namespace App\Models;

use Core\Database;
use PDO;

class Account
{
    // Busca usuário pelo github_id
    public static function findByGithubId($githubId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE github_id = :github_id');
        $stmt->execute(['github_id' => $githubId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Atualiza pelo github_id
    public static function updateByGithubId($githubId, $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE users
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

    // Atualiza pelo id do usuário logado
    public static function updateById($userId, $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE users
            SET 
                username = :username,
                avatar_url = :avatar_url,
                access_token = :access_token,
                github_id = :github_id
            WHERE id = :id
        ');
        return $stmt->execute([
            'username' => $data['username'],
            'avatar_url' => $data['avatar_url'],
            'access_token' => $data['access_token'],
            'github_id' => $data['github_id'],
            'id' => $userId,
        ]);
    }

    // Cria um novo usuário
    public static function create($data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            INSERT INTO users (name, username, avatar_url, access_token, github_id)
            VALUES (:name, :username, :avatar_url, :access_token, :github_id)
        ');
        return $stmt->execute([
            'name' => $data['name'],
            'username' => $data['username'],
            'avatar_url' => $data['avatar_url'],
            'access_token' => $data['access_token'],
            'github_id' => $data['github_id'],
        ]);
    }
}
