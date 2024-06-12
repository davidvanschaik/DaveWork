<?php

declare(strict_types=1);

namespace Src\Foundation\Routing;

class Route
{
    public string $name;
    private array $parts = [];
    private array $parameters = [];

    public function __construct(
        public string $method,
        public string $uri,
        public array  $action,
    ) {}

    public function name(string $name): void
    {
        $this->name = $name;
    }

    public function matches($serverUri): bool
    {
        $this->parts = $this->extractParts($this->uri);
        $serverUriParts = $this->extractParts($serverUri);

        if (count($serverUriParts) !== count($this->parts)) {
            return false;
        }

        foreach ($this->parts as $key => $part) {
            if ($part !== $serverUriParts[$key]) {
                return false;
            }
            if ($part['isParameter']) {
                $this->parameters[$part['name']] = $serverUriParts[$key];
            }
            return true;
        }
        return false;
    }

    public function extractParts(string $uri): array
    {
        $parts = explode('/', $uri);
        $uriParts = [];

        foreach ($parts as $part) {
            if ($part === "") {
                continue;
            }

            $uriParts[] = [
                'name' => $part,
                'isParameter' => str_contains($part, '{')
            ];
        }
        return $uriParts;
    }
}