<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Http\Request;
use Src\Routing\{Kernel, Route};

class MiddlewarePipeline
{
    protected array $middlewareStack = [];
    protected array $middlewares = [];

    public function __construct(
        protected Route   $route,
        protected Kernel  $kernel,
        protected Request $request
    ) {
        $this->middlewares = $route->middleware;
    }

    /**
     * @throws \Exception
     */
    public function run(): void
    {
        $this->setMiddlewareStack();
        $this->executePipeline();
    }

    /**
     * @throws \Exception
     */
    private function setMiddlewareStack(): void
    {
        foreach ($this->middlewares as $middleware) {
            $middlewareClass = 'Src\\Middleware\\' . ucfirst($middleware) . 'Middleware';
            if ($this->checkIfClassExists($middlewareClass)) {
                $this->middlewareStack[] = new $middlewareClass;
            } else {
                throw new \Exception("Class $middlewareClass not found");
            }
        }
    }

    private function checkIfClassExists(string $middlewareClass): bool
    {
        return class_exists($middlewareClass);
    }

    private function executePipeline(): void
    {
        $middlewarePipeline = $this->buildPipeline($this->setFinalMiddleware($this->route));
        $middlewarePipeline($this->request);
    }

    private function setFinalMiddleware(Route $route): callable
    {
        return function ($request) use ($route) {
            $this->kernel->handleFinalMiddleware($route);
        };
    }

    private function buildPipeline(callable $finalMiddleware): callable
    {
        return array_reduce(
            array_reverse($this->middlewareStack),
            function ($next, $middleware) {
                return function ($request) use ($middleware, $next) {
                    return $middleware->handle($request, $next);
                };
            },
            $finalMiddleware
        );
    }
}