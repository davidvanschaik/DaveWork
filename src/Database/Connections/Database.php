<?php

declare(strict_types=1);

namespace Src\Database\Connections;

use Illuminate\Database\Query\Builder as Schema;
use Illuminate\Database\Schema\Builder as Query;
use Src\Core\App;

class Database
{
    protected static Query $schema;

    public function register(): void
    {
        self::$schema = App::getInstance()->resolve('connection');
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