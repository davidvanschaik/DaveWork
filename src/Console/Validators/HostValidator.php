<?php

namespace Src\Console\Validators;

use Src\Console\Response as CLI;

class HostValidator
{
    public function __invoke(array $args): bool
    {
        return $this->validate($args);
    }

    private function validate(array $args): bool
    {
        if (count($args) > 1) {
            CLI::invalidCommand(" To many arguments to command 'host'");
            return false;
        }
        return true;
    }
}