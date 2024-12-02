<?php

namespace Src\Console\Commands\Database;

use Src\Console\Services\DatabaseService as Service;
use Src\Helpers\DatabaseHelper as Helper;

class FreshCommand
{
    public function __invoke(): void
    {
        Helper::dropTables();
        $migrations = Helper::validateMigrations(false);
        (new Service)
            ->validateMigrations('migrate', $migrations)
            ->runMigrations('run', false);
    }
}