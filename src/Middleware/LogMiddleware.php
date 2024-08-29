<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Http\Request;
use Src\Interfaces\Middleware;

class LogMiddleware implements Middleware
{
    public function handle(Request $request, \Closure $next): mixed
    {
        echo 'Log middleware running';
        return $next($request);
    }
}