<?php

namespace Src\Console\Commands;

use Src\Console\Services\MakeService as Service;
use Src\Helpers\FileHelper as Helper;

class MakeCommand
{
    private array $arg;

    public function __construct(array $arg)
    {
        $this->arg = $arg;
    }

    public function __invoke(): void
    {
        $service = new Service();
        $service->validate($this->arg[1], $this->arg[2], $this->arg[3] ?? '')
                ->validateDirectory();
        Helper::makeFile($service->names, $service->types, $service->directories);
    }
}