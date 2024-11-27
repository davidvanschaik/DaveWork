<?php

namespace Src\Providers;

use Src\Core\ServiceProvider;
use Src\View\View;

class ViewServiceProvider extends  ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('view', function () {
            return new View();
        });
    }
}