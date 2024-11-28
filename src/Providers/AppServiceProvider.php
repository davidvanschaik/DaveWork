<?php

declare(strict_types=1);

namespace Src\Providers;

use Src\Core\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $providers = require __DIR__ . "/../../config/app.php";
        array_map(fn ($provider) => (new $provider($this->app))->register(), $providers);
    }
}
