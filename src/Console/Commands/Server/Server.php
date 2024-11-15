<?php

namespace Src\Console\Commands\Server;

use Src\Console\Response as CLI;

class Server extends Request
{
    protected int $port;

    public function __construct()
    {
        $this->port = 8000;
        chdir('public');
        $this->terminateServer($this->fileName());
    }

    protected function availablePort(mixed $process): bool
    {
        if (str_contains(fgets($process), 'Address already in use')) {
            echo '    ' . CLI::echo('GRAY', "Port: [{$this->server()}] already in use... \n");
            pclose($process);
            return true;
        }
        return false;
    }

    protected function server(): string
    {
        return "127.0.0.1:$this->port";
    }

    protected function startServer(mixed $server): void
    {
        sleep(1);
        echo CLI::block() . CLI::echo('GREEN', " Server running on [http://{$this->server()}] \n \n");
        echo CLI::echo('YELLOW', "    Press Ctrl+C to stop the server \n \n");

        $this->validateResponse($server);
    }

    private function terminateServer($file): void
    {
        pcntl_signal(SIGINT, function () use ($file) {
            $this->clear($this->fileName());
            exit(0);
        });
    }
}