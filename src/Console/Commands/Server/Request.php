<?php

namespace Src\Console\Commands\Server;

use Src\Console\Response as CLI;

class Request
{
    protected function clear(string $file): void
    {
        file_put_contents($file, '');
    }

    protected function fileName(): string
    {
        return __DIR__ . '/../../../../storage/logs/server.log';
    }

    protected function validateResponse($server): void
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
        echo '    ' . CLI::echo('GRAY', $info[0]) . "$info[1] $info[2] $info[3] ";
        echo CLI::GRAY . str_repeat('.', 160 - array_sum(array_map('strlen', $info))) . " ~ $info[4]ms \n";
    }
}