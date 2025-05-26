<?php

namespace App\Controllers\Auth;

use App\Controllers\Auth\AuthController;
use App\Models\Account;
use App\Models\User;
use function Core\redirect;

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
                $account = Account::findByUserId($loggedUser['id']);

                if ($account) {
                    Account::updateByUserId($loggedUser['id'], $data);
                } else {
                    $data['user_id'] = $loggedUser['id'];
                    Account::create($data);
                }

                AuthController::setUserSession(array_merge($loggedUser, $data));
            } else {
                $account = Account::findByGithubId($githubUser['id']);

                if ($account) {
                    Account::updateByGithubId($githubUser['id'], $data);
                    $userId = $account['user_id'];

                    $user = User::findById($userId);
                } else {
                    $userId = User::create(
                        $githubUser['name'] ?? $githubUser['login'],
                        $githubUser['email'] ?? null
                    );

                    $data['user_id'] = $userId;
                    Account::create($data);

                    $user = [
                        'id' => $userId,
                        'name' => $githubUser['name'] ?? $githubUser['login'],
                        'email' => $githubUser['email'] ?? null
                    ];
                }

                $account = Account::findByGithubId($githubUser['id']);
                
                AuthController::setUserSession(array_merge($account, [
                    'id' => $user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ]));
            }

        } catch (\PDOException $e) {
            error_log('Error saving account: ' . $e->getMessage());
            return redirect('/', ['error' => 'Failed to save account information. Please try again.']);
        }
    }
}
