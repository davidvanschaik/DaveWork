<?php

declare(strict_types=1);

namespace App\RepositoryRepository;

use RedBeanPHP\R;

class DataController
{
    public static function createUser($username, $email, $password): int|string
    {
        $user = [
            'username' => $username,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];
        return R::store(R::dispense('users')->import($user));
    }

    public static function loginUser($username, $password)
    {
        var_dump($username, $password);

        $user = R::findOne('users', 'username = ?', [$username]);
        if ($user->username == $username && password_verify($password, $user->password)) {
            return $user;
        }
        return false;
    }

    public static function updateUser($id, $username, $email, $password)
    {
        $user = R::load('users', $id);
        $user->username = $username;
        $user->email = $email;
        $user->password = password_hash($password, PASSWORD_DEFAULT);
        return R::store($user);
    }

    public static function createPost($title, $content, $user_id)
    {
        $post = [
            'title' => $title,
            'content' => $content,
            'user_id' => $user_id
        ];
        return R::store(R::dispense('posts')->import($post));
    }
}