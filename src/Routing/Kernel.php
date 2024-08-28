<?php

declare(strict_types=1);

namespace Src\Routing;

use Exception;
use Src\Core\App;
use Src\Http\Request;
use Src\Middleware\MiddlewarePipeline;

class Kernel
{
    private Route $currentRoute;
    private Request $request;

    public function __construct(
        private readonly RouteRegistration $routeRegistration,
        private readonly App $app,
    ) {
        $this->request = $this->app->resolve('request');
    }

    public function setCurrentRoute(Route $route): void
    {
        $this->currentRoute = $route;
    }

    /**
     * @throws Exception
     */
    public function handle(): void
    {
        $route = $this->routeRegistration->findRoute($this->request->method(), $this->request->uri());

        if (empty($this->currentRoute)) {
            $this->setCurrentRoute($route);
        }

        $this->middleware($route);
    }

    /**
     * @throws Exception
     */
    private function middleware(Route $route): void
    {
        (new MiddlewarePipeline($route, $this, $this->request))->run();
    }

    /**
     * @throws Exception
     */
    public function handleFinalMiddleware(Route $route): void
    {
        $this->setCurrentRoute($route);
        $this->callFunction($route);
    }

    public function callFunction(Route $route): void
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