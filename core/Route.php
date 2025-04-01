<?php

namespace Core;

class Route {
    private $action;
    private array $middlewares = [];
    private array $parameters = [];

    public function __construct(callable|array $action) {
        $this->action = $action;
    }

    public function middleware(string|array $middleware): self {
        $this->middlewares = array_merge($this->middlewares, (array)$middleware);
        return $this;
    }

    public function setParameters(array $params): void {
        $this->parameters = $params;
    }

    public function run() {
        // Executa middlewares em sequência
        foreach ($this->middlewares as $middleware) {
            (new $middleware)->handle();
        }

        // Injeta parâmetros dinâmicos (ex: /users/{id})
        /*
        if (!empty($this->parameters)) {
            $_REQUEST['route_params'] = $this->parameters;
        }
        */

        // Executa a ação principal
        if (is_callable($this->action)) {
            return call_user_func($this->action);
        }
        
        if (is_array($this->action)) {
            [$controller, $method] = $this->action;
            return (new $controller)->$method();
        }
    }
}