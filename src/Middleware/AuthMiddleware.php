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

    public function handle(): bool
    {
        if (! $this->checkIfUserIsLoggedIn()) {
            redirect('back');
        }

        if ($this->request->method() == 'POST' && $this->session->has('user_id')) {
            $token = $_POST['csrf_token'];

            if ($this->session->verifyCSRF($token)) {
                $this->handleError('Invalid CSRF Token', 403);
            }
            return false;
        }
        return true;
    }

    public function checkIfUserIsLoggedIn(): bool
    {
        if ($this->session->has('user_id')) {
            return false;
        }
        return true;
    }

    public function verifyCSRFtoken(): bool
    {
        if ($this->request->method() == 'POST' && $this->session->has('user_id')) {
            $token = $_POST['csrf_token'];

            if ($this->session->verifyCSRF($token)) {
                $this->handleError('Invalid CSRF Token');
            }
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