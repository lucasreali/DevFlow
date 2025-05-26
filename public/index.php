<?php
/**
 * Arquivo de entrada principal do DevFlow
 * 
 * Este arquivo é o ponto de entrada para todas as requisições da aplicação.
 * Ele carrega as dependências, configura o ambiente e despacha as requisições
 * para os controladores apropriados através do sistema de rotas.
 * 
 * Fluxo de execução:
 * 1. Carrega o autoloader e os helpers
 * 2. Configura a sessão e o ambiente
 * 3. Inicia o buffer de saída
 * 4. Carrega as rotas
 * 5. Renderiza o layout HTML base
 * 6. Despacha a requisição para o controlador/ação apropriados
 */

// Carrega o autoloader do Composer para gerenciar dependências
require_once __DIR__ . '/../vendor/autoload.php';
// Carrega funções auxiliares personalizadas
require_once __DIR__ . '/../core/helpers.php';

use App\Middleware\CsrfMiddleware;
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

// Middleware de CSRF - atualmente comentado
// CsrfMiddleware::handle();

// Inclui o arquivo de rotas da aplicação
require_once __DIR__ . '/../routes/web.php';

?><!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Font Awesome - Biblioteca de ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    
    <!-- Bootstrap CSS - Framework de UI -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <!-- Estilos personalizados do projeto -->
    <link rel="stylesheet" href="/css/style.css">
    
    <!-- Script do Bootstrap para funcionalidades interativas -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    
    <!-- jQuery - biblioteca JavaScript para manipulação de DOM -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Script global do projeto -->
    <script src="/js/script.js"></script>
    
</head>
<body>
    <!-- Renderiza o conteúdo da rota correspondente -->
    <?= Router::dispatch(); ?>
</body>
</html>
