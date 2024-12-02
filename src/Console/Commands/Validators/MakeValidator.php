<?php

namespace Src\Console\Commands\Validators;

use Src\Abstracts\Command;
use Src\Console\Response as CLI;

class MakeValidator extends Command
{
    protected array $commands = ['controller', 'migration', 'provider', 'middleware', 'model', 'factory', 'view'];

    public function __invoke(array $arg): void
    {
        $this->args = $arg;
        $this->validateCommand();
    }

    private function validateCommand(): void
    {
        $this->validate(1, $this->commands, 1, 'make:')
             ->count($this->countCommands(), "make:", 1)
             ->fileName();
    }

    private function countCommands(): int
    {
        return $this->args[1] == 'model' ? 4 : 3;
    }

    private function fileName(): void
    {
        if (! isset($this->args[2])) {
            CLI::invalidCommand(" Expecting filename");
        }
        $this->hasRelatedFiles();
    }

    private function hasRelatedFiles(): void
    {
        if ($this->args[1] == 'model' && isset($this->args[3])) {
            $this->validateRelatedTypes();
        }
    }

    private function validateRelatedTypes(): void
    {
        if (! in_array($this->args[3], ['f', 'm', 'fm'])) {
            CLI::infoError(3, 'make:');
        }
    }
}