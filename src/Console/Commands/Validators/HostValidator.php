<?php

namespace Src\Console\Commands\Validators;

use Src\Abstracts\Command;

class HostValidator extends Command
{
    public function __invoke(array $arg): void
    {
        $this->args = $arg;
        $this->count(1, '', 0,);
    }
}