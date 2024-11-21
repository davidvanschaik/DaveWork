<?php

namespace Src\Console\Commands;

use Src\Console\Services\HostService as Service;
use Src\Helpers\ServerHelper as Helper;

class HostCommand
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