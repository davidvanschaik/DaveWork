<?php

namespace Src\Console\Commands;

use Src\Abstracts\Command;

class HostCommand extends Command
{
    public function __invoke(array $arg): bool
    {
        $this->args = $arg;
        return $this->count(1, '', 0);
    }
}