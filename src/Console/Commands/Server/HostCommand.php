<?php

namespace Src\Console\Commands\Server;

use Src\Console\Services\HostService as Service;
use Src\Contracts\Command;

class HostCommand implements Command
{
    public function __invoke(): void
    {
        $service = new Service();
        while ($service->availablePort($server = popen("php -S " . $service->server() . " 2>&1", 'r'))) {
            sleep(1);
            Service::$port++;
        }
        $service->startServer($server);
    }
}