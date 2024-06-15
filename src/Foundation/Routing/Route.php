<?php

declare(strict_types=1);

namespace Src\Foundation\Routing;

class Route
{
    public string $name;
    private array $parts = [];
    public readonly array $parameters;

    public function __construct(
        public string $method,
        public string $uri,
        public mixed $action,
    ) {}

    /**
     * @param string $name
     * @return void
     */
    public function name(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @param $serverUri
     * @return bool
     * Validation of the Server Request URI matches the Route URI
     * Defining parameters
     */
    public function matches($serverUri): bool
    {
        $validator = new RouteValidator();

        if ($validator->validateUri($serverUri, $this->uri)) {
            $this->parameters = $validator->parameters;
            return true;
        }
        return false;
    }
}