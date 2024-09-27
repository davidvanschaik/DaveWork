<?php

declare(strict_types=1);

namespace Src\Middleware;

use App\Repositories\UserRepository;
use Src\Core\App;
use Src\Http\Request;
use Src\Interfaces\Middleware;

class VerificationMiddleware implements Middleware
{
    private UserRepository $userRepository;
    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function handle(Request $request, \Closure $next): mixed
    {
        $post = $request->bodyParams();
        $user = $this->userRepository->findUser('email', $post['email']);

        if ($post['submit'] !== 'Sign Up') {
            return $this->checkIfUserExist($post, $user) == false ?? false;
        }
        return $next($request);
    }

    private function checkIfUserExist(array $post , object | null $user): bool
    {
        if ($user === null) {
            redirect('back');
            return false;
        }
        $this->verifyUserInput($post, $user);
    }

    private function verifyUserInput(array $post, object $user): void
    {
        if ($user->email == $post['email'] && password_verify($post['password'], $user->password)) {
            $this->setUserSessionId(App::getInstance()->resolve('session'), $user);
        }
    }

    private function setUserSessionId(object $session, object $user): void
    {
        $session->set('user_id', $user->id);
        redirect('home');
    }
}