<?php

namespace Src\Console;

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

    private function showInfo(): false
    {
        echo CLI::block() . " Manage your project via the terminal with Commander. \n \n";
        CLI::help(['Commands', 'db:', 'make:']);
        exit;
    }

    private function parse(): void
    {
        $command = explode(':', $this->args[0]);
        array_shift($this->args);
        $this->args = array_merge($command, $this->args);
    }

    private function validateCommand(): bool | array
    {
        $class = __NAMESPACE__ . match ($this->args[0]) {
            'help' => $this->showInfo(),
            'db' => "\\Commands\\DatabaseCommand",
            default => "\\Commands\\" . ucfirst($this->args[0]) . 'Command'
        };
        return (new $class)($this->args);
    }
}