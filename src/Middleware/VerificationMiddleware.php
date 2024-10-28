<?php

declare(strict_types=1);

namespace Src\Middleware;

use App\Repositories\UserRepository;
use Src\Core\App;
use Src\Handlers\ErrorHandler;
use Src\Http\Request;
use Src\Interfaces\Middleware;
use Src\Validation\LoginValidation;

class VerificationMiddleware implements Middleware
{
    private array $postData;
    private LoginValidation $loginValidation;
    private Request $request;

    public function __construct()
    {
        $this->request = App::getInstance()->resolve('request');
        $this->loginValidation = new LoginValidation($this->postData = $this->request->bodyParams());
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        if ($this->postData['submit'] !== 'Sign Up') {
            if (! $this->loginValidation->verify($this->postData)) {
                redirect('back');
                return false;
            }
        }
        return $next($request);
    }

    private function verify(): bool
    {
        return $this->loginValidation->verifyUser();
    }

    private function checkIfUserExist()
    {
        if ($this->user === null) {
            redirect('back');
            return false;
        }
        $this->verifyUserInput();
    }

    private function verifyUserInput(): void
    {
        if ($this->user->email === $this->postData['email'] && password_verify($this->postData['password'], $this->user->password)) {
            $this->setUserSessionId(App::getInstance()->resolve('session'));
        }
    }

    private function setUserSessionId(object $session): void
    {
        $session->set('user_id', $this->user->id);
        redirect('home');
    }
}