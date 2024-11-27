<?php

namespace Src\Providers;

use Src\Core\ServiceProvider;
use Src\Http\Request;

class RequestServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->prototype('request', function () {
            return new Request();
        });
    }
}