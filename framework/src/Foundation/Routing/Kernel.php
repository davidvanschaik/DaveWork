<?php

declare(strict_types=1);

namespace Src\Foundation\Routing;

use Src\Http\Request;

class Kernel
{
    public function handle(): void
    {
        $route = Route::findRoute(Request::method(), Request::uri());

//        var_dump($route);

        if (! $route) {
            http_response_code(404);
            return;
        }

        $parameters = $this->extractParameters($route->uri, Request::uri());
        $this->callFunction($route, $parameters);
    }

    public function extractParameters(string $routeUri, string $requestUri): array
    {
        $routeParts = explode('/', $routeUri);
        $requestParts = explode('/', $requestUri);
        $parameters = [];

        foreach ($routeParts as $index => $part) {
            if (str_contains($part, '{')) {
                $parameters[] = $requestParts[$index];
            }
        }
        return $parameters;
    }

    public function callFunction(Register $route, array $parameters): void
    {
        $action = $route->action;

        if (is_callable($action)) {
            call_user_func_array($action, $parameters);
        }
        if (is_array($action)) {
            $controllerName = $action[0];
            $methodName = $action[1];

            $controller = new $controllerName();
            call_user_func_array([$controller, $methodName], $parameters);
        }
        
    }
}