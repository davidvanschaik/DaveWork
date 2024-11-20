<?php

namespace Src\Console\Commands;

use Src\Console\Services\DatabaseService as Service;
use Src\Helpers\DatabaseHelper as Helper;

class RollbackCommand
{
    public function __invoke(): void
    {
        $tables = Helper::tableExist($migrations = Helper::getMigrations(true));
        Helper::validateTables($tables, 'rollback');
        (new Service)->executeMigrations($migrations, $tables, 'down', 'Rolling back');
        echo PHP_EOL;
    }
}