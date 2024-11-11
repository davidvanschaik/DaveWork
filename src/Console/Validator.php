<?php

namespace Src\Console;

use Src\Console\Response as CLI;

class Validator
{
    public array $args;
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
            return CLI::error();
        }
        return $this->commandExist();
    }

    private function commandExist(): bool
    {
        $this->parse();

        if (! in_array($this->args[0], ['make', 'db', 'host', 'server'])) {
            return CLI::error();
        }
        return true;
    }

    private function parse(): void
    {
        $command = explode(':', $this->args[0]);
        array_shift($this->args);
        $this->args = array_merge($command, $this->args);
    }
}