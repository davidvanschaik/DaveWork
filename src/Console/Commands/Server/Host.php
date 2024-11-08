<?php

namespace Src\Console\Commands\Server;

use Src\Console\Response as CLI;
use Src\Console\Commands\Command;

class Host implements Command
{
    private array $arg;

    public function __construct(array $arg)
    {
        $this->arg = $arg;
    }

    public function setCommand(): void
    {
        echo CLI::GREEN . 'Server running on: [http://127.0.0.1:8000]' . PHP_EOL;
        echo CLI::YELLOW . 'Press Ctrl + C to abort' . CLI::RESET . PHP_EOL;
        chdir('public');
        exec('php -S 127.0.0.1:8000');
    }
}