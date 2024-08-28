<?php

declare(strict_types=1);

namespace Src\Handlers;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder as Schema;

class ConnectionHandler
{
    protected Capsule $capsule;

    public function __construct(array $options)
    {
        $this->capsule = new Capsule();

        $this->capsule->addConnection($options);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    public function getConnect(): Capsule
    {
        return $this->capsule;
    }

    public function getSchema(): Schema
    {
        return $this->capsule->schema();
    }
}
