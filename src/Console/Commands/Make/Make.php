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

    public function setCommand(): void
    {
        $this->typeExist($this->arg[1]);
        $this->fileExist($this->arg[2], $dir = $this->getDirectory($this->arg[1]));
        $fileContent = $this->getContent($dir, $this->arg[2]);

        $this->createFile(
            $this->generateFile($fileContent, $this->arg[1]),
            $dir . $this->arg[2] . '.php',
            $this->arg[1]
        );
    }
}