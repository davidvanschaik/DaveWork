<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Contracts\Middleware;
use Src\Http\Request;

class PermissionMiddleware implements Middleware
{
    public function handle(Request $request, \Closure $next): mixed
    {
        return $next($request);
    }
}