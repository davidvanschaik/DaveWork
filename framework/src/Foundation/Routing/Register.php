<?php

declare(strict_types=1);

namespace Src\Foundation\Routing;

class Register
{
    public string $name;
    private array $partials = [];

    public function __construct(
        public string $method,
        public string $uri,
        public array  $action
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
        $partials = [];
        $parts = explode('/', $uri);

        foreach ($parts as $part) {
            if ($part === "") {
                continue;
            }

            $partials[] = [
                'data' => $part,
                'isParameter' => str_contains($part, '{')
            ];
        }

       return $partials;
    }

    public function getPartials(): array
    {
        return $this->partials;
    }
}