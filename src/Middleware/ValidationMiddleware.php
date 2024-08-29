<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Core\App;
use Src\Exceptions\ValidationException;
use Src\Http\Request;
use Src\Interfaces\Middleware;
use Src\Validation\ProfileValidation;

class ValidationMiddleware implements Middleware
{
    private static Request $request;
    private ProfileValidation $profileValidation;
    private array $validationParams;
    private ValidationException $exception;
    private static array $postData;

    public function __construct()
    {
        self::$request = App::getInstance()->resolve('request');
        $this->profileValidation = new ProfileValidation(self::$postData = self::$request->bodyParams());
        $this->exception = App::getInstance()->resolve('validation.exception');
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        if (! self::$request->method() == 'POST') {
            exit();
        }

        $this->setValidationParams();
        $this->checkIfRequestIsLogIn();

        if (! $this->validate()) {
            redirect('back');
            return false;
        }
        return $next($request);
    }

    private function setValidationParams(): void
    {
        match (self::$request->uri()) {
            '/login' => $this->validationParams = ['email', 'password'],
            '/update-profile' => $this->validationParams = ['email', 'phone'],
            '/reset-password' => $this->validationParams = ['password'],
            '/delete-account' => $this->validationParams = ['email', 'username'],
            '/forgot-password' => $this->validationParams = ['email'],
            default => null,
        };
    }

    private function checkIfRequestIsLogIn(): void
    {
        if (self::$postData['submit'] !== 'Log In') {
            array_push($this->validationParams, 'username', 'phone');
            return;
        }
        $this->unsetSignUpData();
    }

    /**
     * @return void
     * Because I handle sign-up and log in from the same uri
     * I need to the unset the sign-up values if the request is log in
     */
    private function unsetSignUpData(): void
    {
        $array = ['username', 'confirm', 'phone'];
        foreach ($array as $info) {
            self::$request->unsetPost($info);
        }
    }

    private function validate(): bool
    {
        $this->callFunction();
        return $this->handleErrors();
    }

    public function callFunction(): void
    {
        foreach ($this->validationParams as $key) {
            $this->exception->set($key, $this->profileValidation->{$key . "Validation"}());
        }
    }

    private function handleErrors(): bool
    {
        $errors = $this->checkIfErrorIsSet($this->exception->errors);

        if (! empty($errors)) {
            $this->exception->store($errors);
            return false;
        }
        return true;
    }

    private function checkIfErrorIsSet(array $errors): array
    {
        $errors = [];
        foreach ($this->exception->errors as $error) {
            if (is_string($error)) {
                $errors[] = $error;
            }
        }
        return $errors;
    }
}