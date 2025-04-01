<?php

namespace Core;

class Router {
    public static array $routes = [];

    public static function get(string $route, callable|array $action): Route {
        return self::registerRoute('GET', $route, $action);
    }

    public static function post(string $route, callable|array $action): Route {
        return self::registerRoute('POST', $route, $action);
    }

    public static function put(string $route, callable|array $action): Route {
        return self::registerRoute('PUT', $route, $action);
    }

    public static function delete(string $route, callable|array $action): Route {
        return self::registerRoute('DELETE', $route, $action);
    }


    private static function registerRoute(string $method, string $route, callable|array $action): Route {
        $routeInstance = new Route($action);
        self::$routes[$method][$route] = $routeInstance;
        return $routeInstance;
    }

    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach (self::$routes[$method] ?? [] as $routePattern => $routeInstance) {
            if (self::uriMatchesRoute($routePattern, $uri)) {
                return $routeInstance->run();
            }
        }

        http_response_code(404);
        return view('404');
    }

    private static function uriMatchesRoute(string $routePattern, string $uri): bool {
        // Implementar lógica para tratar parâmetros dinâmicos (ex: /users/{id})

        return $routePattern === $uri;
    }
}