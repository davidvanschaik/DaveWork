<?php

namespace Src\Console\Commands;

use Src\Abstracts\Command;

class DatabaseCommand extends Command
{
    protected array $commands = ['migrate', 'rollback', 'seed'];

    public function __invoke(array $arg): bool
    {
        $this->args = $arg;
        return $this->validateCommand();
    }

    public function validateCommand(): bool
    {
        if (
            $this->validate(1, $this->commands, 2) &&
            $this->count(2, "db:", 1)
        ) {
            return true;
        }
        return false;
    }
}