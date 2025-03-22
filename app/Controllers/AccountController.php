<?php

namespace App\Controllers;

use App\Models\Account;

class AccountController
{
    public static function store($user, $accessToken)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $account = Account::findByGithubId($user['id']);

            $data = [
                'name' => $user['name'],
                'nickname' => $user['login'],
                'avatar_url' => $user['avatar_url'],
                'access_token' => $accessToken,
                'github_id' => $user['id']
            ];

            if ($account) {
                Account::update($data);
            } else {
                Account::create($data);
            }

            self::setUserSession($data);

        } catch (\PDOException $e) {
            error_log('Erro ao salvar a conta: ' . $e->getMessage());
            header('Location: /error');
            exit;
        }
    }

    private static function setUserSession($user)
    {
        $_SESSION['user'] = [
            'id' => $user['github_id'],
            'nickname' => $user['nickname'],
            'avatar_url' => $user['avatar_url'],
            'access_token' => $user['access_token']
        ];
    }
}
