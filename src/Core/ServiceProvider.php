<?php

declare(strict_types=1);

namespace Src\Core;

abstract class ServiceProvider
{
    protected App $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    abstract function register();
}
