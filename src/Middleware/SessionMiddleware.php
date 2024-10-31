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
        if ($this->session->has('user_id')) {
            $this->setActive($this->session->get('LAST_ACTIVE'));
        }
        return $next($request);
    }

    private function setActive(mixed $lastActive): void
    {
        if ($lastActive && ! $this->checkTimeOut($lastActive)) {
            return;
        }
        $this->session->setActive();
    }

    private function checkTimeOut(mixed $lastActive): bool
    {
        if ((int)implode(explode(':', date('H:i:s'))) >= $this->session->setTimeOutTime()) {
            $this->destroy();
            return false;
        }
        return true;
    }

    private function destroy(): void
    {
        $this->session->destroy();
        redirect('login');
        $this->session->set('errors', ['Session expired, please login again.']);
    }
}