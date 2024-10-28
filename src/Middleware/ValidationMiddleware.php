<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Core\App;
use Src\Handlers\ErrorHandler;
use Src\Http\Request;
use Src\Interfaces\Middleware;
use Src\Validation\SignupValidation;

class ValidationMiddleware implements Middleware
{
    private static Request $request;
    private SignupValidation $signupValidation;
    private array $validationParams;
    private ErrorHandler $errorHandler;
    private static array $postData;

    public function __construct()
    {
        self::$request = App::getInstance()->resolve('request');
        $this->signupValidation = new SignupValidation(self::$postData = self::$request->bodyParams());
        $this->errorHandler = App::getInstance()->resolve('error');
        $this->setValidationParams();
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        if (self::$postData['submit'] !== 'Log In') {
            if (! $this->validate()) {
                redirect('back');
                return false;
            }
        }
        return $next($request);
    }

    private function setValidationParams(): void
    {
        match (self::$request->uri()) {
            '/login'           => $this->validationParams = ['email', 'password', 'username', 'phone'],
            '/update-profile'  => $this->validationParams = ['email', 'phone'],
            '/reset-password'  => $this->validationParams = ['password'],
            '/delete-account'  => $this->validationParams = ['email', 'username'],
            '/forgot-password' => $this->validationParams = ['email'],
            default            => null,
        };
    }

    private function validate(): bool
    {
        $this->callSignupValidationFunction();
        return $this->handleErrors();
    }

    /**
     * In the set function set I give the key value (email, password etc...) and a function that
     * returns an error if the input data is not valid.
     */
    private function callSignupValidationFunction(): void
    {
        foreach ($this->validationParams as $key) {
            $this->errorHandler->set($key, $this->signupValidation->{$key . "Validation"}());
        }
    }

    private function handleErrors(): bool
    {
        $errors = $this->checkIfErrorIsSet();

        if (! empty($errors)) {
            $this->errorHandler->store($errors);
            return false;
        }
        return true;
    }

    private function checkIfErrorIsSet(): array
    {
        $errors = [];
        foreach ($this->errorHandler->errors as $error) {
            if (is_string($error)) {
                $errors[] = $error;
            }
        }
        return $errors;
    }
}