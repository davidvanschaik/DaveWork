<?php

namespace Src\Console;

use Src\Console\Response as CLI;

class Validator
{
    protected array $args;
    protected array $commands = ['make', 'db', 'host', 'help'];

    public function __construct()
    {
        global $argv;
        array_shift($argv);
        $this->args = $argv;
    }

    public function validate(): array
    {
        $this->emptyCommand()
             ->commandExist()
             ->setCommand();
        return $this->args;
    }

    public function emptyCommand(): self
    {
        if (empty($this->args)) {
            CLI::invalidCommand(" No command given. For info: 'php commander help'");
        }
        return $this;
    }

    private function commandExist(): self
    {
        $this->parse();

        if (! in_array($this->args[0], ['make', 'db', 'host', 'help'])) {
            CLI::invalidCommand(" Invalid command. For info: 'php commander help'");
        }
        return $this;
    }

    private function parse(): void
    {
        $command = explode(':', $this->args[0]);
        array_shift($this->args);
        $this->args = array_merge($command, $this->args);
    }

    private function setCommand(): void
    {
        $class = __NAMESPACE__ . "\\Commands\\Validators\\" . match ($this->args[0]) {
            'help' => $this->showInfo(),
            'db' => "DatabaseValidator",
            default => ucfirst($this->args[0]) . 'Validator'
        };
        (new $class)($this->args);
    }

    private function showInfo(): false
    {
        echo CLI::block() . " Manage your project via the terminal with Commander. \n \n";
        CLI::help(['', 'db:', 'make:']);
    }
}