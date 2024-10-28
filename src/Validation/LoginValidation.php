<?php

namespace Src\Validation;

use App\Repositories\UserRepository;
use Src\Core\App;
use Src\Handlers\ErrorHandler;

class LoginValidation
{
    private array $postData;
    private UserRepository $userRepository;
    private ErrorHandler $errorHandler;
    private string $errorMessage;
    private mixed $user;

    public function __construct(array $data)
    {
        $this->postData = $data;
        $this->userRepository = new UserRepository();
        $this->errorHandler = App::getInstance()->resolve('error');
        $this->errorMessage = 'Email or password incorrect. Please try again.';
        $this->user = $this->userRepository->findUser('email', $this->postData['email']);
    }

    public function verify(): bool
    {
        $this->checkIfUserExist();
        return $this->errorHandler->handleErrors();
    }

    private function checkIfUserExist(): void
    {
        if (! $this->user || ! password_verify($this->postData['password'], $this->user->password)) {
            $this->errorHandler->set('email', $this->errorMessage);
        } else {
            $this->setUserSessionId(App::getInstance()->resolve('session'));
        }
    }

    private function setUserSessionId(object $session): void
    {
        $session->set('user_id', $this->user->id);
        redirect('home');
    }
}