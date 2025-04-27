<?php

namespace Core;

class Router {
    public static array $routes = [];
    private static array $groupStack = [];

    public static function group(array $attributes, \Closure $callback): void {
        self::$groupStack[] = $attributes;
        $callback();
        array_pop(self::$groupStack);
    }

    private static function applyGroupAttributes(string &$uri, array &$middlewares): void {
        foreach (self::$groupStack as $group) {
            // Aplica prefixo
            if (isset($group['prefix'])) {
                $uri = trim($group['prefix'], '/') . '/' . trim($uri, '/');
            }

            // Combina middlewares
            if (isset($group['middleware'])) {
                $middlewares = array_merge(
                    $middlewares,
                    (array)$group['middleware']
                );
            }
        }

        // Normaliza a URI final
        $uri = '/' . trim(str_replace('//', '/', $uri), '/');
    }

    public static function get(string $route, array $action): Route {
        return self::registerRoute('GET', $route, $action);
    }

    public static function post(string $route, array $action): Route {
        return self::registerRoute('POST', $route, $action);
    }


    private static function registerRoute(string $method, string $route, array $action): Route {
        $middlewares = [];
        $fullRoute = $route;
        
        // Aplica atributos dos grupos
        self::applyGroupAttributes($fullRoute, $middlewares);

        $routeInstance = new Route($fullRoute, $action);
        
        // Adiciona middlewares acumulados
        foreach ($middlewares as $middleware) {
            $routeInstance->middleware($middleware);
        }

        self::$routes[$method][$fullRoute] = $routeInstance;
        return $routeInstance;
    }

    public static function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach (self::$routes[$method] ?? [] as $routePattern => $routeInstance) {
            if ($routeInstance->matches($uri)) {
                $routeInstance->bindParameters($uri);
                return $routeInstance->run();
            }
        }

        http_response_code(404);
        return view('404');
    }
}