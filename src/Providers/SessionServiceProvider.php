<?php

namespace Src\Providers;

use Src\Core\ServiceProvider;
use Src\Http\Session;

class SessionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('session', function () {
            return new Session();
        });
    }
}