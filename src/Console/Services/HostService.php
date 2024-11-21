<?php

namespace Src\Console\Services;

use Src\Console\Response as CLI;

use Src\Helpers\ServerHelper as Helper;

class HostService
{
    public static int $port;

    public function __construct()
    {
        chdir('public');
        self::$port = 8000;
        Helper::terminateServer($this->fileName());
        Helper::clear($this->fileName());
    }

    public static function server(): string
    {
        return "127.0.0.1:" . self::$port;
    }

    public function availablePort(mixed $process): bool
    {
        if (str_contains(fgets($process), 'Address already in use')) {
            echo '    ' . CLI::echo('GRAY', "Port: [" . self::server() . "] already in use... \n");
            pclose($process);
            return true;
        }
        return false;
    }

    public function startServer(mixed $server): void
    {
        sleep(1);
        echo CLI::block() . CLI::echo('GREEN', " Server running on [http://" . self::server() . "] \n \n");
        echo CLI::echo('YELLOW', "    Press Ctrl+C to stop the server \n \n");

        $this->validateResponse($server);
    }

    protected function validateResponse(mixed $server): void
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

    public static function fileName(): string
    {
        return __DIR__ . '/../../../storage/logs/server.log';
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