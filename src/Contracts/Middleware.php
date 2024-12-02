<?php

declare(strict_types=1);

namespace Src\Contracts;

use Src\Http\Request;

interface Middleware
{
    public function handle(Request $request, \Closure $next): mixed;
}
