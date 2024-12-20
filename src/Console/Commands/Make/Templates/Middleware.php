<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

use Src\Contracts\Middleware;
use Src\Http\Request;

class <?= $name ?> implements Middleware
{
    public function handle(Request $request, \Closure $next): mixed
    {
        //
        return $next($request);
    }
}