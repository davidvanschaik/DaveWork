<?php

namespace Src\Console\Commands\Make;

use Src\Console\Commands\Command;

class Make extends MakeFileController implements Command
{
    public function __construct(array $arg)
    {
        $this->type = $arg[1];
        $this->name = $arg[2];
    }

    public function setCommand(): void
    {
        $this->validate($this->type, $this->name);
        $this->createFile($this->generateFile());
    }
}