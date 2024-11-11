<?php

namespace Src\Console\Commands\Database;

use Src\Console\Commands\Command;

class Rollback extends DatabaseController implements Command
{
    public function setCommand(): void
    {
        $tables = $this->tableExist($migrations = $this->getMigrations(true));
        $this->validateTables($tables, 'rollback');
        $this->executeMigrations($migrations, 'down', 'Rolling back');
        echo PHP_EOL;
    }
}