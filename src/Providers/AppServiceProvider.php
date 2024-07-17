<?php

declare(strict_types=1);

namespace Src\Providers;

use Src\Core\ServiceProvider;
use Src\Exceptions\SyntaxExceptions;
use Src\Exceptions\ValidationException;
use Src\Handlers\ErrorHandler;
use Src\Http\Request;
use Src\Http\Session;
use Src\Routing\Kernel;
use Src\Routing\RouteRegistration;
use Src\View\View;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('route', function () {
            return new RouteRegistration();
        });

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

        $this->app->singleton('validation.exception', function () {
            return new ValidationException();
        });

        $this->app->prototype('PHP.errors', function () {
            return new SyntaxExceptions();
        });
    }

    public function boot()
    {

    }

}