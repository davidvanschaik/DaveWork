<?php

namespace Src\Console\Commands\Server;

use Src\Console\Response as CLI;
use Src\Console\Commands\Command;

class Host implements Command
{
    private int $port;
    private mixed $server;

    public function __construct(array $arg)
    {
        $this->port = 8000;
        chdir('public');
        $this->terminateServer($this->fileName());
    }

    public function setCommand(): void
    {
        while ($this->availablePort($this->server = popen("php -S 127.0.0.1:{$this->port} 2>&1", 'r'))) {
            sleep(1);
            $this->port++;
        }
        $this->startServer();
    }

    private function availablePort(mixed $process): bool
    {
        if (str_contains(fgets($process), 'Address already in use')) {
            echo '    ' . CLI::echo('GRAY', "Port: [127.0.0.1:{$this->port}] already in use... \n");
            pclose($process);
            return true;
        }
        return false;
    }

    private function startServer(): void
    {
        sleep(1);
        echo CLI::block() . CLI::echo('GREEN', " Server running on [http://127.0.0.1:{$this->port}] \n \n");
        echo CLI::echo('YELLOW', "    Press Ctrl+C to stop the server \n \n");

        $this->validateResponse($this->server);
    }

    private function validateResponse($server): void
    {
        $key = 0;

        while (! feof($server)) {
            $this->handleData($data = $this->getData(), $key);
            $key =+ count($data);
            pcntl_signal_dispatch();
        }
    }

    private function getData(): array
    {
        return file($this->fileName(), 2 | 4);
    }

    private function fileName(): string
    {
        return __DIR__ . '/../../../../storage/logs/server.log';
    }

    private function handleData(array $data, int $key): void
    {
        if (count($data) !== 0 || $key < count($data)) {
            for ($x = $key; $x < count($data); $x++) {
                $this->displayActivity(explode(' ', $data[$x]));
            }
        }
    }

    private function displayActivity(array $info): void
    {
        echo '    ' . CLI::echo('GRAY', $info[0]) . "{$info[1]} {$info[2]} {$info[3]} ";
        echo CLI::GRAY . str_repeat('.', 160 - array_sum(array_map('strlen', $info))) . " ~ 0s \n";
    }

    private function terminateServer($file): bool
    {
        return pcntl_signal(SIGINT, function () use ($file) {
            file_put_contents($file, '');
            exit(0);
        });
    }
}