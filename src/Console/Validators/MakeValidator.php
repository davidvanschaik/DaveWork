<?php

namespace Src\Console\Validators;

use Src\Console\Response as CLI;

class MakeValidator
{
    private array $array = [
        'controller', 'migration', 'middleware',
        'model', 'components', 'factory'
    ];

    public function __invoke(array $args): bool
    {
        return $this->validate($args);
    }

    private function validate(array $args): bool
    {
        if (! isset($args[1]) || ! in_array($args[1], $this->array)) {
            CLI::infoError(1);
            die;
        }
        return $this->name($args);
    }

    private function name(array $args): bool
    {
        if (! isset($args[2])) {
            CLI::invalidCommand(" Expecting filename.");
            return false;
        }
        return $this->count($args);
    }

    private function count(array $args): bool
    {
        if ($args[1] !== 'migration' && count($args) > 3) {
            CLI::invalidCommand(" To many arguments to 'make:{$args[1]}'");
            return false;
        }
        return true;
    }
}