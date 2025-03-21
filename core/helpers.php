<?php

namespace Core;

function view(string $viewName, array $data = []) {
    $viewPath = __DIR__ . '/../app/Views/' . $viewName . '.php';

    if (!file_exists($viewPath)) {
        die("Erro: View '$viewName' not found.");
    }

    extract($data);

    require $viewPath;
    return ob_get_clean();
}
