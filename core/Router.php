<?php

namespace Core;

class Router {
    public static array $routes = []; // Array que armazena as rotas

    // Metodos para verificar qual o tipo de requisição
    public static function get(string $route, callable|array $action) {
        self::addRoute('GET', $route, $action);
    }

    public static function post(string $route, callable|array $action) {
        self::addRoute('POST', $route, $action);
    }

    public static function update(string $route, callable|array $action) {
        self::addRoute('UPDATE', $route, $action);
    }

    public static function delete(string $route, callable|array $action) {
        self::addRoute('DELETE', $route, $action);
    }

    /**
     * Adiciona uma nova rota ao roteador.
     *
     * @param string $method O método HTTP associado à rota (por exemplo, 'GET', 'POST').
     * @param string $route O caminho da rota (por exemplo, '/home', '/user/{id}').
     * @param callable|array $action A ação a ser executada quando a rota for acessada.
     *                               Pode ser uma função anônima (callable) ou um array
     *                               contendo o controlador e o método (por exemplo, [Controller::class, 'method']).
     *
     * Este método armazena a rota e sua ação correspondente em um array estático `$routes`,
     * organizado pelo método HTTP e pelo caminho da rota.
     */
    // 
    private static function addRoute(string $method, string $route, callable|array $action) {
        self::$routes[$method][$route] = $action;
    }

    public static function dispatch() {
        // Obtém o método HTTP da requisição (ex.: GET, POST)
        $method = $_SERVER['REQUEST_METHOD'];

        // Obtém o caminho da URI da requisição (ex.: /home, /user/1)
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // Itera sobre as rotas registradas para o método HTTP atual
        foreach (self::$routes[$method] ?? [] as $route => $action) {
            // Verifica se a rota registrada corresponde à URI da requisição
            if ($route === $uri) {
                // Se a ação for uma função anônima (callable), executa-a
                if (is_callable($action)) {
                    echo call_user_func($action);
                    return;
                // Se a ação for um array (controlador e método), instancia o controlador e executa o método
                } elseif (is_array($action)) {
                    [$controller, $method] = $action;
                    echo call_user_func([new $controller, $method]);
                    return;
                }
            }
        }

        // Caso nenhuma rota correspondente seja encontrada, retorna uma resposta 404
        http_response_code(404);
        view('404');
    }
}
