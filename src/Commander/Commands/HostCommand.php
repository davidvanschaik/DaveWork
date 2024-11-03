<?php

namespace Src\Commander\Commands;

use Src\Helpers\CLIHelper as CLI;

class HostCommand
{
    public static function callHost(): void
    {
        echo CLI::GREEN . 'Server running on: [http://127.0.0.1:8000]' . PHP_EOL;
        echo CLI::YELLOW . 'Press Ctrl + C to abort' . CLI::RESET . PHP_EOL;
        chdir('public');
        exec('php -S 127.0.0.1:8000');
    }
}