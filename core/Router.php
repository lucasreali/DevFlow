<?php

namespace Core;

class Router {
    // Array que armazena todas as rotas registradas
    public static array $routes = [];
    // Pilha de grupos de rotas para aplicar atributos como prefixos e middlewares
    private static array $groupStack = [];

    // Define um grupo de rotas com atributos compartilhados
    public static function group(array $attributes, \Closure $callback): void {
        self::$groupStack[] = $attributes; // Adiciona o grupo à pilha
        $callback(); // Executa o callback para registrar as rotas dentro do grupo
        array_pop(self::$groupStack); // Remove o grupo da pilha após o callback
    }

    // Aplica os atributos dos grupos (prefixos e middlewares) às rotas
    private static function applyGroupAttributes(string &$uri, array &$middlewares): void {
        foreach (self::$groupStack as $group) {
            // Aplica o prefixo do grupo à URI
            if (isset($group['prefix'])) {
                $uri = trim($group['prefix'], '/') . '/' . trim($uri, '/');
            }

            // Combina os middlewares do grupo com os middlewares existentes
            if (isset($group['middleware'])) {
                $middlewares = array_merge(
                    $middlewares,
                    (array)$group['middleware']
                );
            }
        }

        // Normaliza a URI final para evitar barras duplicadas
        $uri = '/' . trim(str_replace('//', '/', $uri), '/');
    }

    // Registra uma rota do tipo GET
    public static function get(string $route, array $action): Route {
        return self::registerRoute('GET', $route, $action);
    }

    // Registra uma rota do tipo POST
    public static function post(string $route, array $action): Route {
        return self::registerRoute('POST', $route, $action);
    }

    // Registra uma rota com o método HTTP especificado
    private static function registerRoute(string $method, string $route, array $action): Route {
        $middlewares = []; // Inicializa os middlewares
        $fullRoute = $route; // Define a rota completa inicialmente como a rota passada
        
        // Aplica os atributos dos grupos à rota
        self::applyGroupAttributes($fullRoute, $middlewares);

        // Cria uma nova instância de rota
        $routeInstance = new Route($fullRoute, $action);
        
        // Adiciona os middlewares acumulados à instância da rota
        foreach ($middlewares as $middleware) {
            $routeInstance->middleware($middleware);
        }

        // Armazena a rota registrada no array de rotas
        self::$routes[$method][$fullRoute] = $routeInstance;
        return $routeInstance;
    }

    // Despacha a requisição para a rota correspondente
    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD']; // Obtém o método HTTP da requisição
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH); // Obtém o caminho da URI

        // Itera pelas rotas registradas para o método HTTP atual
        foreach (self::$routes[$method] ?? [] as $routePattern => $routeInstance) {
            // Verifica se a URI corresponde ao padrão da rota
            if ($routeInstance->matches($uri)) {
                $routeInstance->bindParameters($uri); // Associa os parâmetros da URI à rota
                return $routeInstance->run(); // Executa a rota
            }
        }

        // Retorna um erro 404 se nenhuma rota corresponder
        http_response_code(404);
        return view('404'); // Renderiza a página 404
    }
}