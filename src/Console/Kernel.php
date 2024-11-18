<?php

namespace Src\Console;

use Src\Console\Validators\Validator;

require 'config/database.php';

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
        $class = __NAMESPACE__ . $this->getDirectory($arg);
        (new $class($arg))();
    }

    private function getDirectory(array $arg): string
    {
         return match ($arg[0]) {
            'db' => "\\Commands\\Database\\$arg[1]",
            'make' => "\\Commands\\Make\\$arg[0]",
            'host' => "\\Commands\\Server\\$arg[0]",
             'help' => exit,
            default => null
        };
    }
}