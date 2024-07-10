<?php

declare(strict_types=1);

namespace Src\Core;

use Exception;

class Container
{
    protected array $instances = [];
    public array $shared = [];

    public function bind(string $key, callable $func): void
    {
        $this->instances[$key] = $func;
    }

    /**
     * @throws \Exception
     */
    public function get(string $key): mixed
    {
        if (array_key_exists($key, $this->shared)) {
            return $this->returnSingleton($key);
        }

        if (isset($key, $this->instances[$key])) {
            return call_user_func($this->instances[$key]);
        }

        dd("No match found for $key");
    }

    private function returnSingleton(string $key): mixed
    {
        if ($this->shared[$key] == null) {
            $this->shared[$key] = $this->instances[$key];
        }
        return call_user_func($this->shared[$key]);
    }
}