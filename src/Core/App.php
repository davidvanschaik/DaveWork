<?php

declare(strict_types=1);

namespace Src\Core;

class App
{
    protected static Container $container;

    public static function setContainer($container): void
    {
        self::$container = $container;
    }

    public static function prototype(string $key, callable $func): void
    {
        self::$container->bind($key, $func);
    }

    public static function singleton($key, $func): void
    {
        self::$container->shared[$key] = null;
        self::$container->bind($key, $func);
    }

    public static function resolve($key): mixed
    {
        return self::$container->get($key);
    }
}