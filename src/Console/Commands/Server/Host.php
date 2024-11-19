<?php

namespace Src\Console\Commands\Server;

class Host extends Server
{
    public function __construct()
    {
        parent::__construct();
        $this->clear($this->fileName());
    }

    public function __invoke(): void
    {
        while ($this->availablePort($server = popen("php -S {$this->server()} 2>&1", 'r'))) {
            sleep(1);
            $this->port++;
        }
        $this->startServer($server);
    }
}