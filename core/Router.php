<?php

namespace Core;

class Router {
    public static array $routes = [];

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

    private static function addRoute(string $method, string $route, callable|array $action) {
        self::$routes[$method][$route] = $action;
    }

    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach (self::$routes[$method] ?? [] as $route => $action) {
            if ($route === $uri) {
                if (is_callable($action)) {
                    echo call_user_func($action);
                    return;
                } elseif (is_array($action)) {
                    [$controller, $method] = $action;
                    echo call_user_func([new $controller, $method]);
                    return;
                }
            }
        }

        http_response_code(404);
        view('404');
    }
}
