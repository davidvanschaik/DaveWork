<?php

namespace Src\Validation;

use App\Repositories\UserRepository;
use Src\Core\App;

class LoginValidation
{
    private array $postData;
    private UserRepository $userRepository;

    public function __construct(array $postData)
    {
        $this->postData = $postData;
        $this->userRepository = new UserRepository();
    }

    public function verifyUser()
    {
        return $this->checkIfUserExist();
    }

    private function checkIfUserExist()
    {
        if (! $this->userRepository->findUser('email', $this->postData['email'])) {
            redirect('back');
            return false;
        }
        $this->verifyUserInput();
    }

    private function verifyUserInput()
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