<?php

declare(strict_types=1);

namespace Src\Middleware;

use App\Repositories\UserRepository;
use Src\Core\App;
use Src\Handlers\ErrorHandler;
use Src\Http\Request;
use Src\Interfaces\Middleware;

class VerificationMiddleware implements Middleware
{
    private UserRepository $userRepository;

    private array $postData;
    private ErrorHandler $errorHandler;
    private mixed $user;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->errorHandler = App::getInstance()->resolve('error');
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        $this->postData = $request->bodyParams();
        $this->user = $this->userRepository->findUser('email', $this->postData['email']);
        return $this->checkIfRequestIsLogin() ?? $next($request);
    }

    private function checkIfRequestIsLogin()
    {
        if ($this->postData['submit'] !== 'Sign Up') {
            return $this->checkIfUserExist();
        }
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