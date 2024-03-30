<?php

namespace App\Core;

use App\Core\Uri;
use App\Core\HttpCode;

class Router
{
    private $routes = [];

    public function routeToController(Uri $uri, string $method): mixed
    {
        if (empty($this->routes)) {
            throw new \Exception("Not found", HttpCode::NOT_FOUND);
        }
        foreach ($this->routes as $route) {
            if ($route->getUri() == $uri->getUri() and array_key_exists($method, $route->getMethods())) {

                $controller = $route->getController();
                $action = $route->getMethods()[$method];
                $body = $route->getBody();

                return $controller->$action($body);
            }
        }
        throw new \Exception("Not found", HttpCode::NOT_FOUND);
    }

    public function addRoute(Route $route): void
    {
        array_push($this->routes, $route);
    }
}
