<?php

namespace Src\Console\Commands\Database;

use Src\Console\Commands\Command;

class Migrate extends DatabaseController implements Command
{
    private array $arg;
    public function __construct(array $arg)
    {
        $this->arg = $arg;
    }

    public function setCommand(): void
    {
        $tables = $this->tableExist($migrations = $this->getMigrations(), false);
        $this->validateTables($tables, 'migrate');

        echo 'INFO: Running migrations' . PHP_EOL;
        $this->executeMigrations($migrations, 'run');
    }
}