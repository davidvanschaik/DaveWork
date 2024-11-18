<?php

namespace Src\Console\Validators;

use Src\Console\Response as CLI;

class Validator
{
    protected array $args;

    public function __construct()
    {
        global $argv;
        array_shift($argv);
        $this->args = $argv;
    }

    public function validate(): array
    {
        return ! $this->emptyCommand() ? [] : $this->args;
    }

    public function emptyCommand(): bool
    {
        if (empty($this->args)) {
            CLI::invalidCommand(" No command given. For info: 'php commander help'");
             return false;
        }
        return $this->commandExist();
    }

    private function commandExist(): bool
    {
        $this->parse();

        if (! in_array($this->args[0], ['make', 'db', 'host', 'help'])) {
            CLI::invalidCommand(" Invalid command. For info: 'php commander help'");
            return false;
        }
        return $this->validateCommand();
    }

    private function parse(): void
    {
        $command = explode(':', $this->args[0]);
        array_shift($this->args);
        $this->args = array_merge($command, $this->args);
    }

    private function validateCommand(): bool
    {
        $class = __NAMESPACE__ . match ($this->args[0]) {
            'db' => "\\DatabaseValidator",
            default => "\\" . ucfirst($this->args[0]) . 'Validator'
        };
        return (new $class)($this->args);
    }
}