<?php

declare(strict_types=1);

namespace Src\Core;

use Src\Providers\AppServiceProvider;

class App
{
    private static self $instance;
    protected Container $container;

    private function __construct(Container $container)
    {
        $this->container = $container;
        $this->run();
    }

    public static function getInstance(): self
    {
        if (empty(self::$instance)) {
            self::$instance = new self(new Container());
        }
        return self::$instance;
    }

    public function run(): void
    {
        (new AppServiceProvider($this))->register();
    }

    public function prototype(string $key, callable $func): void
    {
        $this->container->bind($key, $func);
    }

    public function singleton(string $key, callable $func): void
    {
        $this->container->shared[$key] = null;
        $this->container->bind($key, $func);
    }

    /**
     * @throws \Exception
     */
    public function resolve(string $key): mixed
    {
        return $this->container->get($key);
    }
}