<?php

declare(strict_types=1);

namespace Src\Database\Connections;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Builder as Schema;

class Connection
{
    protected Capsule $capsule;

    public function __construct(array $options)
    {
        $this->capsule = new Capsule();

        $this->capsule->addConnection($options);
        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    public function getSchema(): Schema
    {
        return $this->capsule->schema();
    }
}
