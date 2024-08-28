<?php

declare(strict_types=1);

namespace Src\Interfaces;

use Src\Http\Request;

interface Middleware
{
    public function handle(Request $request, \Closure $next): callable;
}
