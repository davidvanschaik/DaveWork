<?php

namespace Src\Console\Validators;

use Src\Console\Response as CLI;

class HelpValidator
{
    public function __invoke(array $args): bool
    {
        return $this->validate($args);
    }

    private function validate(array $args): bool
    {
        if (count($args) > 1) {
            CLI::invalidCommand(" To many arguments to command 'help'");
            return false;
        }
        return $this->showInfo();
    }

    private function showInfo(): true
    {
        echo CLI::block() . " Manage your project via the terminal with Commander. \n \n";
        CLI::help(['Commands', 'db:', 'make:']);
        return true;
    }
}