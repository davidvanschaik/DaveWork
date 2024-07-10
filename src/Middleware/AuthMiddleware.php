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

    public function __construct(
        private readonly Session $session
    )
    {
        $this->request = App::getInstance()->resolve('request');
    }

    public function handle(): bool
    {
        if (! $this->session->has('user_id')) {
            $this->redirect('/login');
            return false;
        }

        if ($this->session->has('user_id') && ! $this->session->has('LAST_ACTIVE')) {
            $this->csrfToken = $this->session->generateCSRF();
        }

        if ($this->request->method() == 'POST') {
            $token = $_POST['csrf_token']  ?? '';

            if ($this->session->verifyCSRF($token)) {
                $this->handleError('Invalid CSRF Token', 403);
            }
            return false;
        }
        return true;
    }

    private function redirect($url): void
    {
        $this->handleError('User must be logged in', 401);
        header("Location: $url" );
    }

    private function handleError($message, $responseCode): Response
    {
        $response = new Response();
        return $response->returnMessage([
            'message' => $message,
            'response code' => $responseCode
        ]);
    }
}