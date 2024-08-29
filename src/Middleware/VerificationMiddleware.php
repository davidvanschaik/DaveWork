<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Http\Request;
use Src\Interfaces\Middleware;

class VerificationMiddleware implements Middleware
{
    public function __construct() {}

    public function handle(Request $request, \Closure $next): mixed
    {
        return $next($request);
    }
}