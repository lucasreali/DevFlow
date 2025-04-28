<?php

namespace Core;

function view(string $viewName, array $data = []) {
    // Define o caminho completo para o arquivo da view com base no nome fornecido
    $viewPath = __DIR__ . '/../app/Views/' . $viewName . '.php';

    // Verifica se o arquivo da view existe; se não, encerra o script com uma mensagem de erro
    if (!file_exists($viewPath)) {
        die("Erro: View '$viewName' not found.");
    }

    // Extrai as chaves do array $data como variáveis individuais
    // Por exemplo, ['title' => 'Home'] se torna $title = 'Home'
    extract($data);

    // Inclui o arquivo da view para ser processado
    require $viewPath;
    // Retorna o conteúdo do buffer de saída e limpa o buffer
    // Isso permite capturar o conteúdo gerado pela view como uma string
    return ob_get_clean();
}

function redirect(string $route, array $data = []): never {
    // Armazena os dados na sessão
    $_SESSION['__redirect_data'] = [
        'data' => $data,
        'expires' => time() + 30 // Expira em 30 segundos
    ];
    
    // Redireciona para a rota
    header("Location: $route");
    exit();
}