<?php

namespace Src\Abstracts;

use Src\Console\Response as CLI;

abstract class Command
{
    protected array $args;

    abstract function __invoke(array $arg);

    protected function validate(int $key, array $commands, string $commandInfo): bool
    {
        if (empty($this->args[$key]) || ! in_array($this->args[$key], $commands)) {
            CLI::infoError($commandInfo);
            return false;
        }
        return true;
    }

    protected function count(int $count, string $message, int $key): bool
    {
        if (count($this->args) > $count) {
            CLI::invalidCommand(" To many arguments to '$message{$this->args[$key]}'");
            return false;
        }
        return true;
    }
}