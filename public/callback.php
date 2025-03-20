<?php

use App\Controllers\AccountController;
use App\Controllers\UserController;
use Dotenv\Dotenv;

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$clientId = $_ENV['GITHUB_CLIENT_ID'];
$clientSecret = $_ENV['GITHUB_CLIENT_SECRET'];
$redirectUri = $_ENV['GITHUB_REDIRECT_URI'];
if (!isset($_GET['code'])) {
    die("Error: Authorization code not found.");
}

$code = $_GET['code'];

$tokenUrl = 'https://github.com/login/oauth/access_token';

$tokenData = http_build_query([
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'code' => $code,
    'redirect_uri' => $redirectUri
]);

$options = [
    'http' => [
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\nAccept: application/json\r\n",
        'method'  => 'POST',
        'content' => $tokenData,
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($tokenUrl, false, $context);

$result = json_decode($response, true);

if (!isset($result['access_token'])) {
    die("Erro ao obter o token de acesso. Resposta do GitHub: " . json_encode($result));
}

$accessToken = $result['access_token'];

$userUrl = 'https://api.github.com/user';
$options = [
    'http' => [
        'header'  => "User-Agent: MeuApp\r\nAuthorization: token $accessToken\r\n",
        'method'  => 'GET',
    ],
];

$context = stream_context_create($options);
$response = file_get_contents($userUrl, false, $context);

$user = json_decode($response, true);

if (!$user) {
    die("Erro: Falha ao obter informações do usuário.");
}

AccountController::store($user, $accessToken);

if (!isset($_SESSION)) {
    session_start();
}

$_SESSION['user'] = $user;


header('Location: /');
exit;