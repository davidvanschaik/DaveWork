<?php

declare(strict_types=1);

namespace Src\Middleware;

use Src\Contracts\Middleware;
use Src\Core\App;
use Src\Http\Request;
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
            if (! $this->loginValidation->verify()) {
                redirect('back');
                return false;
            }
        }
        return $next($request);
    }
}