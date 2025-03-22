<?php

use App\Controllers\AccountController;
use Dotenv\Dotenv;

// Carrega o autoloader do Composer para gerenciar dependências
require_once __DIR__ . '/../vendor/autoload.php';

// Carrega as variáveis de ambiente do arquivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Obtém as credenciais do GitHub a partir das variáveis de ambiente
$clientId = $_ENV['GITHUB_CLIENT_ID'];
$clientSecret = $_ENV['GITHUB_CLIENT_SECRET'];
$redirectUri = $_ENV['GITHUB_REDIRECT_URI'];

// Verifica se o código de autorização foi retornado na URL
if (!isset($_GET['code'])) {
    die("Error: Authorization code not found.");
}

$code = $_GET['code'];

// URL para obter o token de acesso do GitHub
$tokenUrl = 'https://github.com/login/oauth/access_token';

// Dados necessários para a requisição do token de acesso
$tokenData = http_build_query([
    'client_id' => $clientId,
    'client_secret' => $clientSecret,
    'code' => $code,
    'redirect_uri' => $redirectUri
]);

// Configurações da requisição HTTP para obter o token de acesso
$options = [
    'http' => [
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\nAccept: application/json\r\n",
        'method'  => 'POST',
        'content' => $tokenData,
    ]
];

// Cria o contexto da requisição HTTP
$context = stream_context_create($options);

// Faz a requisição para obter o token de acesso
$response = file_get_contents($tokenUrl, false, $context);

// Decodifica a resposta JSON
$result = json_decode($response, true);

// Verifica se o token de acesso foi retornado
if (!isset($result['access_token'])) {
    die("Erro ao obter o token de acesso. Resposta do GitHub: " . json_encode($result));
}

$accessToken = $result['access_token'];

// URL para obter informações do usuário autenticado
$userUrl = 'https://api.github.com/user';

// Configurações da requisição HTTP para obter informações do usuário
$options = [
    'http' => [
        'header'  => "User-Agent: MeuApp\r\nAuthorization: token $accessToken\r\n",
        'method'  => 'GET',
    ],
];

// Cria o contexto da requisição HTTP
$context = stream_context_create($options);

// Faz a requisição para obter informações do usuário
$response = file_get_contents($userUrl, false, $context);

// Decodifica a resposta JSON com os dados do usuário
$user = json_decode($response, true);

// Verifica se as informações do usuário foram obtidas com sucesso
if (!$user) {
    die("Error: Failed to retrieve user information.");
}

// Armazena as informações do usuário e o token de acesso no banco de dados
AccountController::store($user, $accessToken);

// Inicia a sessão, se ainda não estiver iniciada
if (!isset($_SESSION)) {
    session_start();
}

// Armazena as informações do usuário na sessão
$_SESSION['user'] = $user;

// Redireciona o usuário para a página inicial
header('Location: /');
exit;