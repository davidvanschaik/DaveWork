<?php

declare(strict_types=1);

namespace Src\Routing;

use Src\Validation\RouteValidation;

class Route
{
    public array $middleware = ['auth', 'session'];

    public string $name;
    public array $parameters;

    public function __construct(
        public readonly string $method,
        public readonly string $uri,
        public readonly mixed $action,
    ) {}

    public function name(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function middleware(...$middleware): self
    {
        array_push($this->middleware, ...$middleware);
        return $this;
    }

    /**
     * @param $serverUri
     * @return bool
     * Validation of the Server Request URI matches the Route URI
     * Defining parameters
     */
    public function matches($serverUri): bool
    {
        $validator = new RouteValidation();

        if ($validator->validateUri($serverUri, $this->uri)) {
            $this->parameters = $validator->parameters;
            return true;
        }
        return false;
    }
}