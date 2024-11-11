<?php

namespace Src\Console\Commands\Database;

use Src\Console\Commands\Command;

class Migrate extends DatabaseController implements Command
{
    public function setCommand(): void
    {
        $tables = $this->tableExist($migrations = $this->getMigrations(false));
        $this->validateTables($tables, 'migrate');
        $this->executeMigrations($migrations, 'run', 'Running');
        echo PHP_EOL;
    }
}