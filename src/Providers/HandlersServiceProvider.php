<?php

declare(strict_types=1);

namespace Src\Providers;

use Src\Core\ServiceProvider;
use Src\Handlers\ErrorHandler;

class HandlersServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->prototype('error', function () {
            return new ErrorHandler();
        });
    }
}