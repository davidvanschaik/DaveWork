<?php

namespace Src\Console\Commands;

use Src\Console\Services\DatabaseService as Service;
use Src\Helpers\DatabaseHelper as Helper;

class MigrateCommand
{
    public function __invoke(): void
    {
        $tables = Helper::tableExist($migrations = Helper::getMigrations(false));
        Helper::validateTables($tables, 'migrate');
        (new Service)->executeMigrations($migrations, $tables, 'run', 'Running');
        echo PHP_EOL;
    }
}