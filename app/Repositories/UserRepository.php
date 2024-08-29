<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UserRepository
{
    public function fetchAll(): Collection
    {
        return User::all();
    }

    public function insert(array $userInfo): Model
    {
        return User::create($userInfo);
    }

    public function signUp(array $data)
    {
        $errors = $this->checkIfUserCredentialsExist($data);
        if ($errors != null) {
            return $errors;
        }

        return $this->insert([
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'phone' => $data['phone'],
        ]);
    }

    public function checkIfUserCredentialsExist(array $data): array | string
    {
        $errors = [];
        foreach (['email', 'username', 'phone'] as $info) {
            $user = $this->findUser($info, $data[$info]);
            if ($user != null) {
                $errors[$info] = ucfirst($info) . ' already in use';
                break;
            }
        }
        return $errors;
    }

    private function findUser(string $row, string $userData)
    {
        return User::where($row, $userData)->first();
    }
}