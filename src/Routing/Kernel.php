<?php

declare(strict_types=1);

namespace Src\Routing;

use Src\Http\Request;
use Src\Http\Session;
use Src\Middleware\AuthMiddleware;
use Src\Middleware\ValidationMiddleware;

class Kernel
{
    private array $middlewareMap;
    private Route $currentRoute;
    private Request $request;

    public function __construct(
        private RouteRegistration $routeRegistration,
    ) {
        $this->request = Request::getInstance();
        $this->middlewareMap = [
            'validation' => new ValidationMiddleware(),
            'auth' => new AuthMiddleware(new Session()),
        ];
    }

    private function setCurrentRoute(Route $route): void
    {
        $this->currentRoute = $route;
    }

    public function handle(): void
    {
        $route = $this->routeRegistration->findRoute($this->request->method(), $this->request->uri());

        if (empty($this->currentRoute)) {
            $this->setCurrentRoute($route);
        }

        if (! $route) {
            http_response_code(404);
            return;
        }

        $this->middleware($route);
    }

    /**
     * @param Route $route
     * @return void
     */
    private function middleware(Route $route): void
    {
        foreach ($route->middleware as $middleware) {
            $middleware = $this->middlewareMap[$middleware];
                if (! $middleware->handle()) {
                    header("Location:{$this->currentRoute->uri}");
                    exit();
                }
            }
        $this->setCurrentRoute($route);
        $this->callFunction($route);
    }

    /**
     * @param Route $route
     * @return void
     */
    private function callFunction(Route $route): void
    {
        $action = $route->action;

        if (! empty($route->parameters)) {
            $this->request->setParameters($route->parameters);
        }

        if (is_array($action) && count($action) === 2) {
            (new $action[0]())->{$action[1]}($this->request);
        } else {
            call_user_func($action);
        }
    }
}