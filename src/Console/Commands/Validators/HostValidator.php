<?php

namespace Src\Console\Commands\Validators;

use Src\Abstracts\CommandValidator;

class HostValidator extends CommandValidator
{
    public function __invoke(array $arg): void
    {
        $this->args = $arg;
        $this->count(1, '', 0,);
    }
}