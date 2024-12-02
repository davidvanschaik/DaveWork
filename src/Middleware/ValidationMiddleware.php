<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Contracts\Middleware;
use Src\Core\App;
use Src\Http\Request;
use Src\Validation\SignupValidation;

class ValidationMiddleware implements Middleware
{
    private Request $request;
    private SignupValidation $signupValidation;
    private array $validationParams;
    private array $postData;

    public function __construct()
    {
        $this->request = App::getInstance()->resolve('request');
        $this->signupValidation = new SignupValidation($this->postData = $this->request->bodyParams());
        $this->setValidationParams();
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        if ($this->postData['submit'] !== 'Log In') {
            if (! $this->validate()) {
                redirect('back');
                return false;
            }
        }
        return $next($request);
    }

    private function setValidationParams(): void
    {
        $this->validationParams = match ($this->request->uri()) {
            '/login'           => ['email', 'password', 'username', 'phone'],
            '/update-profile'  => ['email', 'phone'],
            '/reset-password'  => ['password'],
            '/delete-account'  => ['email', 'username'],
            '/forgot-password' => ['email'],
            default            => null,
        };
    }

    private function validate(): bool
    {
        return $this->signupValidation->validateCredentials($this->validationParams);
    }
}