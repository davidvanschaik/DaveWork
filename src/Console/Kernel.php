<?php

namespace Src\Console;

class Kernel
{
    public function handle(): void
    {
        if (empty($arg = (new Validator())->validate())) {
            return;
        }
        $this->callFunction($arg);
    }

    private function callFunction(array $arg): void
    {
        $class = $this->getDirectory($arg);
        (new $class($arg))();
    }

    private function getDirectory(array $arg): string
    {
         return __NAMESPACE__ . "\\Commands\\" . match ($arg[0]) {
            'db' => "$arg[1]Command",
            'make', 'host' => "$arg[0]Command",
            'help' => exit
        };
    }
}