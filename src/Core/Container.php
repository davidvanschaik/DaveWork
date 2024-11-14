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

    public function get(string $key): mixed
    {
        if (array_key_exists($key, $this->shared)) {
            return $this->shared[$key];
        }

        if (isset($key, $this->instances[$key])) {
            return call_user_func($this->instances[$key]);
        }

        var_dump("No match found for $key") . die;
    }
}