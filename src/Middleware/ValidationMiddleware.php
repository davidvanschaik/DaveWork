<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Core\App;
use Src\Http\Request;
use Src\Http\Session;
use Src\Interfaces\Middleware;
use Src\Validation\ProfileValidation;

class ValidationMiddleware implements Middleware
{
    private Request $request;
    private ProfileValidation $profileValidation;
    private array $validationParams;

    public function __construct()
    {
        $this->request = App::getInstance()->resolve('request');
        $this->profileValidation = new ProfileValidation($this->request->BodyParams());
    }

    public function handle(): bool
    {
        if (! $this->request->method() == 'POST') {
            exit();
        }

        match ($this->request->uri()) {
            '/login' => $this->validationParams = ['email', 'password'],
            '/register'  => $this->validationParams = ['email', 'password', 'username', 'phone'],
            '/update-profile' => $this->validationParams = ['email', 'phone'],
            '/reset-password' => $this->validationParams = ['password'],
            '/delete-account' | '/forgot-password' => $this->validationParams = ['email'],
            default => null,
        };

        if (! $this->validate()) {
            redirect('back');
        }
        return true;
    }

    private function validate(): bool
    {
        $validation = App::getInstance()->resolve('validation.exception');

        foreach ($this->validationParams as $key) {
            $method = $key . "Validation";
            $result = $this->profileValidation->$method();

            if ($result !== null) {
                $validation->setException($key, $result);
            }
        }

        if (empty($validation->getExceptions())) {
            return true;
        }
        return false;
    }
}