<?php

namespace Src\Commander\Commands;

use Src\Helpers\CLIHelper as CLI;

class InterfaceHandler
{
    public static function validate(string $arg, array $commands): bool
    {
        if (! in_array(strtolower($arg), $commands)) {
            self::displayError();
            return false;
        }
        return true;
    }

    public static function displayError(): void
    {
        echo CLI::RED . 'Invalid command given.' . CLI::RESET . PHP_EOL;
        echo "More info:" . CLI::GREEN . " 'php commander help'" . PHP_EOL;
    }
}