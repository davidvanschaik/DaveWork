<?php

namespace Src\Console\Commands\Database;

use Src\Console\Services\DatabaseService as Service;
use Src\Helpers\DatabaseHelper as Helper;

class RollbackCommand
{
    public function __invoke(): void
    {
        $migrations = Helper::validateMigrations(true);
        (new Service)
            ->validateMigrations('rollback', $migrations)
            ->startMigrating('Rolling back', 'down');
    }
}