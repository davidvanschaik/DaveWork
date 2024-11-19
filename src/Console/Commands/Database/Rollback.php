<?php

namespace Src\Console\Commands\Database;

use Src\Console\Commands\Database\Service\DatabaseService;

class Rollback extends DatabaseService
{
    public function __invoke(): void
    {
        $tables = $this->tableExist($migrations = $this->getMigrations(true));
        $this->validateTables($tables, 'rollback');
        $this->executeMigrations($migrations, $tables, 'down', 'Rolling back');
        echo PHP_EOL;
    }
}