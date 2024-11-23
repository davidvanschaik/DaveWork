<?php

namespace Src\Console\Commands;

use Src\Console\Services\DatabaseService as Service;
use Src\Helpers\DatabaseHelper as Helper;

class MigrateCommand
{
    public function __invoke(): void
    {
        $this->mainMigrations();
        $this->sourceMigrations();
    }

    private function mainMigrations(): void
    {
        $tables = Helper::tableExist($migrations = Helper::getMigrations(false));
        Helper::validateTables($tables, 'migrate');
        (new Service)
            ->startMigrations($migrations, $tables,'Running')
            ->runMigrationWithOutput($migrations, 'run');
        ;
        echo PHP_EOL;
    }

    private function sourceMigrations(): void
    {
        $tables = Helper::tableExist($migrations = Helper::getMigrations(false, 'src/Database'));
        Helper::validateTables($tables, 'migrate');
        (new Service())
            ->requireFile(Helper::migrationsFile($migrations, $tables), 'src/Database')
            ->runMigrationWithoutOutput($migrations, 'run');
    }
}