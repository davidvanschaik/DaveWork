<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Core\App;
use Src\Http\{Request, Session};
use Src\Interfaces\Middleware;

class SessionMiddleware implements Middleware
{
    private Session $session;
    private Request $request;

    public function __construct()
    {
        $this->session = App::getInstance()->resolve('session');
        $this->request = App::getInstance()->resolve('request');
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        $this->checkIfUserIsLoggedIn($this->session->get('user_id'));
        $this->session->setActive();

        return $next($request);
    }

    private function checkIfUserIsLoggedIn($userId): void
    {
        if (! $userId && $this->request->uri() !== '/login') {
            redirect('login');
            exit;
        }

        if ($userId && $this->request->uri() === '/login') {
            redirect('home');
            exit;
        }
    }
}