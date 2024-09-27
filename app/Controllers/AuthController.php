<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\UserRepository;
use Src\Http\Request;
use Src\View\View;

class AuthController
{
    public View $view;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->view = new View();
        $this->userRepository = new UserRepository();
    }

    public function index(Request $request): void
    {
//        dd($request);
        echo view('login', ['errors' => errors()]);
    }

    public function handle(Request $request): void
    {
        $post = $request->bodyParams();
        $post['submit'] === 'Log In' ? $this->login($post) : $this->signUp($post);
    }

    private function login(array $loginInfo) /*TODO*/
    {
        // TODO login system
    }

    private function signUp(array $data): void
    {
        $errors = $this->userRepository->signUp($data);
        if (gettype($errors) == 'object') {
            $errors = ['success' => 'Successfully signed up! Please confirm your email'];
        }
        echo view('login', ['errors' => $errors]);
    }
}