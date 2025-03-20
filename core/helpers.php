<?php

namespace Core;

function view(string $viewName, array $data = []) {
    $viewPath = __DIR__ . '/../app/Views/' . $viewName . '.php';

    if (!file_exists($viewPath)) {
        die("Erro: View '$viewName' não encontrada.");
    }

    extract($data);

    ob_start();
    require $viewPath;
    return ob_get_clean();
}
