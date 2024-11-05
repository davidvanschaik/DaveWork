<?php

namespace Src\Console\Commands\Database;

use Src\Console\Commands\Command;

class Seed implements Command
{
    private array $arg;

    public function __construct(array $arg)
    {
        $this->arg = $arg;
    }

    public function setCommand()
    {
        echo 'seed controller';
    }
}