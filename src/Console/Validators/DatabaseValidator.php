<?php

namespace Src\Console\Validators;

use Src\Console\Response as CLI;

class DatabaseValidator
{
    public function __invoke(array $args): bool
    {
        return $this->validate($args);
    }

    private function validate(array $args): bool
    {
        if (! isset($args[1]) || ! in_array($args[1], ['migrate', 'rollback', 'seed'])) {
            CLI::infoError(2);
            return false;
        }
        return $this->count($args);
    }

    private function count(array $args): bool
    {
        if (count($args) > 2) {
            CLI::invalidCommand(" To many arguments to 'db:{$args[1]}'");
            return false;
        }
        return true;
    }
}