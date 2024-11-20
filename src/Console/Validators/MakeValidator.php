<?php

namespace Src\Console\Validators;

use Src\Abstracts\Command;
use Src\Console\Response as CLI;

class MakeValidator extends Command
{
    protected array $commands = ['controller', 'migration', 'middleware', 'model', 'factory', 'view'];

    public function __invoke(array $arg): bool
    {
        $this->args = $arg;
        return $this->validateCommand();
    }

    private function validateCommand(): bool
    {
        if (
            $this->validate(1, $this->commands, 1) &&
            $this->count($this->countCommands(), "make:", 1) &&
            $this->fileName() && $this->relatedFiles()
        ) {
            return true;
        }
        return false;
    }

    private function countCommands(): int
    {
        return $this->args[1] == 'model' ? 4 : 3;
    }

    private function fileName(): bool
    {
        if (! isset($this->args[2])) {
            CLI::invalidCommand(" Expecting filename.");
        }
        return true;
    }

    private function relatedFiles(): bool
    {
        if ($this->args[1] == 'model'
            && isset($this->args[3])
            && ! in_array($this->args[3], ['f', 'm', 'fm'])
        ) {
            CLI::infoError(1);
        }
        return true;
    }
}