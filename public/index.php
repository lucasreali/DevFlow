<?php

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../core/helpers.php';

use Core\Router;
use Dotenv\Dotenv;

// Define o tempo de vida do cookie de sessão para 30 dias
ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);

// Carrega as variáveis de ambiente do arquivo .env localizado no diretório raiz do projeto
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Inicia a sessão PHP
session_start();

// Inicia o buffer de saída para capturar e manipular a saída antes de enviá-la ao navegador
ob_start();

// Inclui o arquivo de rotas da aplicação
require_once __DIR__ . '/../routes/web.php';

?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Style Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Style CSS -->
    <link rel="stylesheet" href="css/style.css">
    
    <!-- Script Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- Script jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Script JS -->
    <script src="js/script.js"></script>
    
</head>
<body>
    <!-- Renderiza o conteúdo da rota correspondente -->
    <?= Router::dispatch(); ?>
</body>
</html>
