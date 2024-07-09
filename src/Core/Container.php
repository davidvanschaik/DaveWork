<?php

declare(strict_types=1);

namespace Src\Core;

class Container
{
    protected array $instances = [];
    public array $shared = [];

    public function bind(string $key, callable $func): void
    {
        $this->instances[$key] = $func;
    }

    public function get(string $key): mixed
    {
        if (array_key_exists($key, $this->shared)) {
            return $this->returnSingleton($key);
        }

        if (isset($key, $this->instances[$key])) {
            return $this->instances[$key];
        }

        throw new \Exception("No match found for $key");
    }

    private function returnSingleton(string $key)
    {
        if ($this->shared[$key] == null) {
            $this->shared[$key] = $this->instances[$key];
        }
        return $this->shared[$key];
    }
}