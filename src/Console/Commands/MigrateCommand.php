<?php

namespace Src\Console\Commands;

use Src\Console\Services\DatabaseService as Service;
use Src\Helpers\DatabaseHelper as Helper;

class MigrateCommand
{
    public function __invoke(): void
    {
        $migrations = Helper::validateMigrations(false);
        (new Service)
            ->validateMigrations('migrate', $migrations)
            ->startMigrating('Running', 'run');
    }
}