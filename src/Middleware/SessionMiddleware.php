<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Contracts\Middleware;
use Src\Core\App;
use Src\Handlers\SessionTimeOutHandler;
use Src\Http\Request;
use Src\Http\Session;

class SessionMiddleware implements Middleware
{
    private Session $session;

    public function __construct()
    {
        $this->session = App::getInstance()->resolve('session');
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        if ($this->session->has('user_id')) {
            $this->setActive($this->session->get('LAST_ACTIVE'));
        }
        return $next($request);
    }

    private function setActive(mixed $lastActive): void
    {
        if ($lastActive && ! $this->checkTimeOut()) {
            $this->destroy();
            return;
        }
        $this->session->setActive();
    }

    private function checkTimeOut(): bool
    {
//        Time Out Duration in seconds.
        return (new SessionTimeOutHandler($this->session, 5))->checkTimeOut();
    }

    private function destroy(): void
    {
        $this->session->destroy();
        redirect('login');
        $this->session->set('errors', ['Session expired, please login again.']);
    }
}