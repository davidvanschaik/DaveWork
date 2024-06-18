<?php

declare(strict_types=1);

namespace Src\Routing;

use Src\Http\Request;

readonly class Kernel
{
    public function __construct(
        private RouteRegistration $routeRegistration
    ) {}

    public function handle(): void
    {
        $route = $this->routeRegistration->findRoute(Request::method(), Request::uri());

        if (! $route) {
            http_response_code(404);
            return;
        }

        $this->callFunction($route);
    }

    /**
     * @param Route $route
     * @return void
     */
    private function callFunction(Route $route): void
    {
        $action = $route->action;

        if (is_array($action) && count($action) === 2) {
            (new $action[0]())->{$action[1]}(new Request($route->parameters));
        } else {
            call_user_func($action);
        }
    }
}