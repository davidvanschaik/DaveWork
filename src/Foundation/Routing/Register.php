<?php

declare(strict_types=1);

namespace Src\Foundation\Routing;

use Src\Http\Request;

class Register
{
    public string $name;
    private array $partials = [];
    private static array $parameters = [];

    public function __construct(
        public string $method,
        public string $uri,
        public array  $action,
        public Request $request
    )
    {
        $this->partials = self::extractPartials($uri);
    }

    public function name(string $name)
    {
        $this->name = $name;
    }

    public static function extractPartials(string $uri): array
    {
        $parts = explode('/', $uri);

        foreach ($parts as $part) {
            if ($part === "") {
                continue;
            }

            $partials[] = [
                'data' => $part,
                'isParameter' => str_contains($part, '{'),
                'parameterData' => ''
            ];
        }

        return $partials;
    }

    public function getPartials(): array
    {
        return $this->partials;
    }

    public function setUri($uri)
    {
        return $this->$uri = $uri;
    }
}