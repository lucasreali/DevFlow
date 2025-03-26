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

        header('Location: /');
        exit;
    }

    private static function getAccessToken($clientId, $clientSecret, $code, $redirectUri)
    {
        $tokenUrl = 'https://github.com/login/oauth/access_token';
        $postFields = [
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'code' => $code,
            'redirect_uri' => $redirectUri,
        ];

        $ch = curl_init();
        // Define a URL para onde a requisição será enviada
        curl_setopt($ch, CURLOPT_URL, $tokenUrl);

        // Define que o método da requisição será POST
        curl_setopt($ch, CURLOPT_POST, true);

        // Define os dados que serão enviados no corpo da requisição
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postFields));

        // Configura para que a resposta da requisição seja retornada como string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Define o cabeçalho da requisição, especificando que a resposta deve ser em JSON
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        return $result['access_token'] ?? null;
    }

    private static function getUser($accessToken)
    {
        $userUrl = 'https://api.github.com/user';

        $ch = curl_init();
        // Define a URL para onde a requisição será enviada
        curl_setopt($ch, CURLOPT_URL, $userUrl);

        // Configura para que a resposta da requisição seja retornada como string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Define o cabeçalho da requisição, incluindo o User-Agent e o token de autorização
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'User-Agent: DevFlow', // Identifica o cliente que está fazendo a requisição
            'Authorization: token ' . $accessToken // Inclui o token de acesso para autenticação
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response, true);
    }
}
