<?php

namespace Src\Console\Commands\Database;

use Src\Console\Commands\Command;

class Rollback extends DatabaseController implements Command
{
    private array $arg;
    public function __construct(array $arg)
    {
        $this->arg = $arg;
    }

    public function setCommand(): void
    {
        $tables = $this->tableExist($migrations = $this->getMigrations(), true);
        $this->validateTables($tables, 'rollback');

        echo 'INFO: Rolling back migrations' . PHP_EOL;
        $this->executeMigrations($migrations, 'down');
    }
}