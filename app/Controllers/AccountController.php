<?php

namespace App\Controllers;

use App\Controllers\Auth\AuthController;
use App\Models\Account;

class AccountController
{
    public static function store($githubUser, $accessToken)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $loggedUser = $_SESSION['user'] ?? null;

            // Dados recebidos do GitHub
            $data = [
                'username' => $githubUser['login'],
                'avatar_url' => $githubUser['avatar_url'],
                'access_token' => $accessToken,
                'github_id' => $githubUser['id'],
            ];

            if ($loggedUser) {
                $data = array_merge($loggedUser, $data);
                Account::updateById($loggedUser['id'], $data);
                AuthController::setUserSession($data);
            } 
            else {
                $account = Account::findByGithubId($githubUser['id']);

                $data['name'] = $githubUser['name'] ?? $githubUser['login'];
                $data['email'] = $githubUser['email'] ?? null;
                if ($account) {
                    Account::updateByGithubId($githubUser['id'], $data);
                    $data = array_merge($account, $data);
                } else {
                    
                    Account::create($data);

                    $data['id'] = Account::getLastInsertId();
                }
                AuthController::setUserSession($data);
            }

        } catch (\PDOException $e) {
            error_log('Erro ao salvar a conta: ' . $e->getMessage());
            header('Location: /error');
            exit;
        }
    }
}
