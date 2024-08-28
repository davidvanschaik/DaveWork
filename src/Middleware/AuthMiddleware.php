<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Core\App;
use Src\Http\Request;
use Src\Http\Response;
use Src\Http\Session;
use Src\Interfaces\Middleware;

class AuthMiddleware implements Middleware
{
    protected string $csrfToken;
    private Request $request;
    private Session $session;

    public function __construct()
    {
        $this->request = App::getInstance()->resolve('request');
        $this->session = App::getInstance()->resolve('session');
    }

    public function handle(Request $request, \Closure $next): callable
    {
        if (! $this->checkIfUserIsLoggedIn()) {
            redirect('back');
        }

        if (! $this->session->has('csrf_token')) {
            $this->setCSRFtoken();
        } else {
            if (! $this->verifyCSRFToken()) {
                return $next($request);
            }
        }
        return $next($request);
    }

    public function checkIfUserIsLoggedIn(): bool
    {
        if ($this->session->has('user_id')) {
            return false;
        }
        return true;
    }

    public function setCSRFToken(): void
    {
        if ($this->request->method() == 'POST' && $this->session->has('user_id')) {
            $this->csrfToken = $_POST['csrf_token'];
        }
    }

    public function verifyCSRFToken(): bool
    {
        if ($this->session->verifyCSRF($this->csrfToken)) {
            return false;
        }
        return true;
    }

    public function handleError($message): void
    {
        $exception = App::getInstance()->resolve('exception');
        $exception->store($message);
    }
}