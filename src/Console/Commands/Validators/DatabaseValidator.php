<?php

namespace Src\Console\Commands\Validators;

use Src\Abstracts\Command;

class DatabaseValidator extends Command
{
    protected array $commands = ['migrate', 'rollback', 'seed', 'fresh'];

    public function __invoke(array $arg): void
    {
        $this->args = $arg;
        $this->validateCommand();
    }

    public function validateCommand(): void
    {
        $this->validate(1, $this->commands, 2, 'make:');
        $this->count(2, "db:", 1);
    }
}