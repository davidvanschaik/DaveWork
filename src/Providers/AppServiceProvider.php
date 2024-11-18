<?php

declare(strict_types=1);

namespace Src\Providers;

use Src\Core\ServiceProvider;
use Src\Exceptions\SyntaxExceptions;
use Src\Handlers\ErrorHandler;
use Src\Http\Request;
use Src\Http\Session;
use Src\View\View;

// TODO breaking up the service providers in categories
class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->prototype('request', function () {
            return new Request();
        });

        $this->app->singleton('session', function () {
            return new Session();
        });

        $this->app->singleton('view', function () {
            return new View();
        });

        $this->app->prototype('error', function () {
            return new ErrorHandler();
        });

        $this->app->prototype('PHP.errors', function () {
            return new SyntaxExceptions();
        });
    }
}
