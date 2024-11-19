<?php

namespace Src\Console\Commands\Database;

use Src\Console\Commands\Database\Service\DatabaseService;

class Migrate extends DatabaseService
{
    public function __invoke(): void
    {
        $tables = $this->tableExist($migrations = $this->getMigrations(false));
        $this->validateTables($tables, 'migrate');
        $this->executeMigrations($migrations, $tables, 'run', 'Running');
        echo PHP_EOL;
    }
}