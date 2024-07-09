<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Http\Request;
use Src\Http\Session;
use Src\Interfaces\Middleware;
use Src\Validation\ProfileValidation;

class ValidationMiddleware implements Middleware
{
    private Request $request;
    private Session $session;
    private ProfileValidation $profileValidation;
    private array $validationParams;

    public function __construct()
    {
        $this->request = Request::getInstance();
        $this->session = new Session();
        $this->profileValidation = new ProfileValidation($this->request->BodyParams());
    }

    public function handle(): bool
    {
        if ($this->request->method() === 'POST') {

            match ($this->request->uri()) {
                '/login' => $this->validationParams = ['email', 'password'],
                '/register'  => $this->validationParams = ['email', 'password', 'username', 'phone'],
                '/update-profile' => $this->validationParams = ['email', 'phone'],
                '/reset-password' => $this->validationParams = ['password'],
                '/delete-account' | '/forgot-password' => $this->validationParams = ['email'],
                default => null,
            };
            return $this->validate();
        }
        return true;
    }

    private function validate(): bool
    {
        foreach ($this->validationParams as $key) {
            $method = $key . "Validation";
            $result = $this->profileValidation->$method();

            if ($result !== null) {
                $this->request->setErrors($key, $result);
            }
        }
        return true;
    }
}