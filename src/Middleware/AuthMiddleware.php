<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Core\App;
use Src\Http\Request;
use Src\Http\Session;
use Src\Interfaces\Middleware;

class AuthMiddleware implements Middleware
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
        $this->checkIfUserIsLoggedIn();
        return $next($request);
    }

    private function checkIfUserIsLoggedIn(): void
    {
        if (! $this->session->get('user_id')) {
            $this->redirectLogin();
        } else {
            $this->redirectHome();
        }
    }

    private function redirectLogin(): void
    {
        if ($this->request->uri() !== '/login') {
            redirect('login');
            exit;
        }
    }

    private function redirectHome(): void
    {
        if ($this->request->uri() === '/login') {
            redirect('home');
            exit;
        }
    }
}