<?php

declare(strict_types=1);

namespace Src\Providers;

use Src\Core\ServiceProvider;
use Src\Database\Connections\Connection;
use Src\Database\Connections\Database;

class ConnectionServiceProvider extends ServiceProvider
{
    function register(): void
    {
        $options = require_once __DIR__ . '/../../config/database.php';
        $this->app->singleton('connection', function () use ($options) {
            return (new Connection($options))->getSchema();
        });

        (new Database())->register();
    }
}