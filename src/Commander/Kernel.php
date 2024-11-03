<?php

namespace Src\Commander;

use Src\Commander\Commands\Database\MigrationController;
use Src\Commander\Commands\InterfaceHandler;
use Src\Commander\Commands\HostCommand as Host;
use Src\Commander\Commands\Make\MakeController;

class Kernel
{
    private array $arg;
    private mixed $fileName;

    public function __construct(array $arg)
    {
        $this->arg = explode(':', $arg[1]);
        $this->fileName = $arg[2] ?? '';
    }

    public function run(): void
    {
        if (! InterfaceHandler::validate($this->arg[0], ['host', 'db', 'make'])) {
            return;
        }
        $this->match();
    }

    private function match(): void
    {
        match (strtolower($this->arg[0])) {
            'host' => $this->runLocalHost(),
            'db' => $this->database(),
            'make' => $this->make()
        };
    }

    private function runLocalHost(): void
    {
        Host::callHost();
    }

    private function database(): void
    {
        if (! InterfaceHandler::validate($this->arg[1], ['migrate', 'rollback', 'seed'])) {
            return;
        }
        (new MigrationController($this->arg[1]))->run();
    }

    private function make(): void
    {
        if (! InterfaceHandler::validate($this->arg[1], ['controller', 'model', 'migration', 'view'])) {
            return;
        }
        (new MakeController())->run($this->arg[1], $this->fileName);
    }
}