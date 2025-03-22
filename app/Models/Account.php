<?php

namespace App\Models;

use Core\Database;
use PDO;

class Account
{
    public static function findByGithubId($githubId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('SELECT * FROM users WHERE github_id = :github_id');
        $stmt->execute(['github_id' => $githubId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function update($data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare('
            UPDATE users
            SET access_token = :access_token,
                avatar_url = :avatar_url
            WHERE github_id = :github_id
        ');
        return $stmt->execute([
            'access_token' => $data['access_token'],
            'avatar_url' => $data['avatar_url'],
            'github_id' => $data['github_id'],
        ]);
    }

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
