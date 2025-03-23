<?php

namespace App\Controllers;

use App\Models\Account;
use App\Helpers\SessionHelper;

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

            // Se houver usuário logado, atualiza apenas os campos desejados
            if ($loggedUser) {
                Account::updateById($loggedUser['id'], $data);
                SessionHelper::setUserSession(array_merge($loggedUser, $data));
            } 
            // Se não houver usuário logado, tenta criar ou atualizar por github_id
            else {
                $account = Account::findByGithubId($githubUser['id']);

                if ($account) {
                    Account::updateByGithubId($githubUser['id'], $data);
                } else {
                    Account::create(array_merge($data, [
                        'name' => $githubUser['name'] ?? 'Unknown',
                    ]));
                }
                SessionHelper::setUserSession($data);
            }

        } catch (\PDOException $e) {
            error_log('Erro ao salvar a conta: ' . $e->getMessage());
            header('Location: /error');
            exit;
        }
    }
}
