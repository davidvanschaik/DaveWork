<?php

declare(strict_types=1);

namespace Src\Providers;

use Illuminate\Database\Schema\Builder;
use Src\Handlers\ConnectionHandler;

class DatabaseServiceProvider
{
    protected static ConnectionHandler $connectionHandler;

    public static function register(array $options): void
    {
        self::$connectionHandler = new ConnectionHandler($options);
    }

    public static function get(): Builder
    {
        return self::$connectionHandler->getSchema();
    }
}