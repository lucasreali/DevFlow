<?php

namespace App\Controllers\Auth;

use App\Controllers\AccountController;
use Dotenv\Dotenv;

class CallbackController
{
    public static function handle()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();

        $clientId = $_ENV['GITHUB_CLIENT_ID'];
        $clientSecret = $_ENV['GITHUB_CLIENT_SECRET'];
        $redirectUri = $_ENV['GITHUB_REDIRECT_URI'];

        if (!isset($_GET['code'])) {
            die("Error: Authorization code not found.");
        }

        $code = $_GET['code'];
        $accessToken = self::getAccessToken($clientId, $clientSecret, $code, $redirectUri);

        if (!$accessToken) {
            die("Error: Failed to get access token.");
        }

        $user = self::getUser($accessToken);

        if (!$user) {
            die("Error: Failed to retrieve user information.");
        }

        AccountController::store($user, $accessToken);

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION['user'] = $user;

        header('Location: /');
        exit;
    }

    private static function getAccessToken($clientId, $clientSecret, $code, $redirectUri)
    {
        $tokenUrl = 'https://github.com/login/oauth/access_token';
        $tokenData = http_build_query([
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $code,
            'redirect_uri' => $redirectUri
        ]);

        $options = [
            'http' => [
                'header' => "Content-Type: application/x-www-form-urlencoded\r\nAccept: application/json\r\n",
                'method' => 'POST',
                'content' => $tokenData,
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($tokenUrl, false, $context);
        $result = json_decode($response, true);

        return $result['access_token'] ?? null;
    }

    private static function getUser($accessToken)
    {
        $userUrl = 'https://api.github.com/user';
        $options = [
            'http' => [
                'header' => "User-Agent: DevFlow\r\nAuthorization: token $accessToken\r\n",
                'method' => 'GET',
            ],
        ];

        $context = stream_context_create($options);
        $response = file_get_contents($userUrl, false, $context);

        return json_decode($response, true);
    }
}