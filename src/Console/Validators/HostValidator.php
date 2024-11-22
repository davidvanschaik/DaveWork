<?php

namespace Src\Console\Validators;

use Src\Abstracts\Command;

class HostValidator extends Command
{
    public function __invoke(array $arg): bool
    {
        $this->args = $arg;
        $this->count(1, '', 0,);
    }
}