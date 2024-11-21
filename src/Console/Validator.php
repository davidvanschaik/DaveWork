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
        $this->parse();
        return ! $this->validateCommand() ? [] : $this->args;
    }

    private function parse(): void
    {
        $command = explode(':', $this->args[0]);
        array_shift($this->args);
        $this->args = array_merge($command, $this->args);
    }

    public function validateCommand(): bool
    {
        if (empty($this->args) || ! in_array($this->args[0], $this->commands)) {
            CLI::invalidCommand(" Invalid command given. For info: 'php commander help'");
            return false;
        }
        return $this->setCommand();
    }

    private function setCommand(): bool | array
    {
        $class = __NAMESPACE__ . match ($this->args[0]) {
            'help' => $this->showInfo(),
            'db' => "\\Validators\\DatabaseValidator",
            default => "\\Validators\\" . ucfirst($this->args[0]) . 'Validator'
        };
        return (new $class)($this->args);
    }

    private function showInfo(): false
    {
        echo CLI::block() . " Manage your project via the terminal with Commander. \n \n";
        CLI::help(['Commands', 'db:', 'make:']);
    }
}