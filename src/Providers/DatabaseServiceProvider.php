<?php

declare(strict_types=1);

namespace Src\Providers;

use Illuminate\Database\Query\Builder as Schema;
use Illuminate\Database\Schema\Builder as Query;
use Src\Database\Connections\Connection;

class DatabaseServiceProvider
{
    protected static Query $schema;

    public static function register(array $options): void
    {
        self::$schema = (new Connection($options))->getSchema();
    }

    public static function get(): Query
    {
        return self::$schema;
    }

    public static function table(string $table): Schema
    {
        return self::$schema->getConnection()->table($table);
    }
}