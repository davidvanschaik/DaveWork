<?php

namespace Src\Console\Commands\Make;

use Src\Console\Commands\Command;

class Make extends MakeFileController implements Command
{
    private array $arg;

    public function __construct(array $arg)
    {
        $this->arg = $arg;
    }

    public function __invoke(): void
    {
        $this->validate($this->arg[1], $this->arg[2]);
        $this->createFile($this->generateFile());
    }
}