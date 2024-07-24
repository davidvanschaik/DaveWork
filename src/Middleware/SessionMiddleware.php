<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Core\App;
use Src\Http\Session;
use Src\Interfaces\Middleware;

class SessionMiddleware implements Middleware
{
    private Session $session;
    public function __construct()
    {
        $this->session = App::getInstance()->resolve('session');
    }
        public function handle(): bool
        {
            if (! $this->checkIfUserIsLoggedIn()) {
                return;
            }

            $this->session->setActive();
        }

        private function checkIfUserIsLoggedIn(): bool
        {

        }
}