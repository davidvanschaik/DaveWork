<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Http\Request;
use Src\Interfaces\Middleware;

class CacheMiddleware implements Middleware
{
    public function handle(Request $request, \Closure $next): mixed
    {
        echo 'Cache middleware running';
        return $next($request);
    }
}