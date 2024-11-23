<?php

namespace Src\Console\Commands;

use Src\Console\Services\DatabaseService as Service;
use Src\Core\App;
use Src\Helpers\DatabaseHelper as Helper;
use Src\Providers\DatabaseServiceProvider as DB;

class RollbackCommand
{
    public function __invoke(): void
    {
        $this->sourceMigrations();
        $this->mainMigrations();
    }

    private function mainMigrations(): void
    {
        $tables = Helper::tableExist($migrations = Helper::getMigrations(true));
        Helper::validateTables($tables, 'rollback');
        (new Service)
            ->startMigrations($migrations, $tables,'Rolling back')
            ->runMigrationWithOutput($migrations, 'down');
        ;
        echo PHP_EOL;
    }

    private function sourceMigrations(): void
    {
        $tables = Helper::tableExist($migrations = Helper::getMigrations(true, 'src/Database'));
        Helper::validateTables($tables, 'rollback');
        (new Service())
            ->requireFile(Helper::migrationsFile($migrations, $tables), 'src/Database')
            ->runMigrationWithoutOutput($migrations, 'down');
    }
}