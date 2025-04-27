<?php

namespace Core;

class Route {
    private $action; // Define a ação associada à rota (controlador e método).
    private array $middlewares = []; // Lista de middlewares associados à rota.
    private array $parameters = []; // Parâmetros extraídos da URI.
    private string $pattern; // Padrão da rota (ex.: "/user/{id}").
    private array $parameterNames = []; // Nomes dos parâmetros definidos no padrão.

    public function __construct(string $pattern, array $action) {
        $this->pattern = $pattern; // Define o padrão da rota.
        $this->action = $action; // Define a ação associada à rota.
        $this->extractParameterNames(); // Extrai os nomes dos parâmetros do padrão.
    }

    // Extrai os nomes dos parâmetros do padrão da rota.
    private function extractParameterNames(): void {
        preg_match_all('/\{(\w+)\}/', $this->pattern, $matches);
        $this->parameterNames = $matches[1]; // Armazena os nomes dos parâmetros.
    }

    // Verifica se a URI corresponde ao padrão da rota.
    public function matches(string $uri): bool {
        $regex = $this->getMatchingRegex(); // Obtém o regex correspondente ao padrão.
        return (bool)preg_match($regex, $uri); // Retorna true se houver correspondência.
    }

    // Associa os parâmetros extraídos da URI aos nomes definidos no padrão.
    public function bindParameters(string $uri): void {
        $regex = $this->getMatchingRegex(); // Obtém o regex correspondente ao padrão.
        preg_match($regex, $uri, $matches); // Extrai os valores dos parâmetros.
        
        foreach ($this->parameterNames as $name) { // Associa os valores aos nomes.
            if (isset($matches[$name])) {
                $this->parameters[$name] = $matches[$name];
            }
        }
    }

    // Gera o regex para verificar e extrair parâmetros da URI.
    private function getMatchingRegex(): string {
        $regex = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $this->pattern); // Substitui parâmetros por regex.
        return '@^' . $regex . '$@'; // Retorna o regex completo.
    }

    // Adiciona middlewares à rota.
    public function middleware(string|array $middleware): self {
        $this->middlewares = array_merge($this->middlewares, (array)$middleware); // Mescla middlewares.
        return $this; // Retorna a instância atual para encadeamento.
    }

    // Executa a rota, incluindo middlewares e a ação associada.
    public function run() {
        // Recupera e limpa dados de redirecionamento
        $redirectData = $this->getRedirectData();

        // Executa middlewares
        foreach ($this->middlewares as $middleware) {
            (new $middleware)->handle();
        }

        // Combina parâmetros da rota com dados de redirecionamento
        $allData = array_merge($this->parameters, $redirectData);

        // Executa o controller
        if (is_array($this->action)) {
            [$controller, $method] = $this->action;
            return (new $controller)->$method($allData);
        }
    }

    private function getRedirectData(): array {
        if (empty($_SESSION['__redirect_data'])) {
            return [];
        }

        $data = $_SESSION['__redirect_data'];

        // Verifica expiração
        if ($data['expires'] < time()) {
            unset($_SESSION['__redirect_data']);
            return [];
        }

        // Remove os dados após consumo
        unset($_SESSION['__redirect_data']);
        
        return $data['data'] ?? [];
    }
}