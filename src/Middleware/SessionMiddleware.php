<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Core\App;
use Src\Http\{Request, Session};
use Src\Interfaces\Middleware;

class SessionMiddleware implements Middleware
{
    private Session $session;
    public function __construct()
    {
        $this->session = App::getInstance()->resolve('session');
    }
        public function handle(Request $request, \Closure $next): mixed
        {
            $this->checkIfUserIsLoggedIn();
            $this->session->setActive();

            return $next($request);
        }

        private function checkIfUserIsLoggedIn()
        {

        }
}