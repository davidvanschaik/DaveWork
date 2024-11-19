<?php

namespace Src\Console\Commands\Make;

use Src\Console\Commands\Make\Service\FileTypeService;

class Make extends FileTypeService
{
    private array $arg;

    public function __construct(array $arg)
    {
        $this->arg = $arg;
    }

    public function __invoke(): void
    {
        $this->validate($this->arg[1], $this->arg[2], $this->arg[3] ?? '');
        $this->validateDirectory();
        $this->makeFile($this->names, $this->types, $this->directories);
    }
}