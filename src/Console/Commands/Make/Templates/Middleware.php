<?= "<?php\n" ?>

declare(strict_types=1);

namespace <?= $namespace ?>;

use Src\Interfaces\Middleware;
use Src\Http\Request;

class <?= $className ?> implements Middleware

{
    public function handle(Request $request, \Closure $next): mixed
    {
        //
        return $next($request);
    }
}