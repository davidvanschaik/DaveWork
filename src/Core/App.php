<?php

declare(strict_types=1);

namespace Src\Core;

class App
{
    private static self $instance;
    protected Container $container;

    private function __construct(Container $container)
    {
        $this->container = $container;
    }

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new App(new Container());
        }
        return self::$instance;
    }

    public function run(): void
    {
        $providers = require __DIR__ . "/../../config/app.php";
        array_map(fn ($provider) => (new $provider($this))->register(), $providers['providers']);
    }

    public function prototype(string $key, callable $func): void
    {
        $this->container->bind($key, $func);
    }

    public function singleton(string $key, callable $func): void
    {
        $this->container->shared[$key] = call_user_func($func);
    }

    public function resolve(string $key): mixed
    {
        return $this->container->get($key);
    }
}