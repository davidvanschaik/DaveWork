<?php

declare(strict_types=1);
require __DIR__ . '/../../vendor/autoload.php';

use Src\Core\App;
use Src\Routing\RouteRegistration as Route;

if (!function_exists('dd')) {
    function dd(mixed $var): void
    {
        $location = debug_backtrace();
        echo "<pre>";
        echo 'File: ' . $location[0]['file'] . PHP_EOL;
        echo 'Line: ' . $location[0]['line'] . PHP_EOL . PHP_EOL;
        var_dump($var);
        echo "</pre>";
        die();
    }
}

if (!function_exists('view')) {
    function view(string $templateName, array $data = []): string
    {
        $view = App::getInstance()->resolve('view');
        return $view->render($templateName, $data);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $routeName): void
    {
        $request = App::getInstance()->resolve('request');
        if ($routeName == 'back') {
            header("Location:" . $request->uri());
        }
        array_map(fn($route) => array_map(function ($info) use ($routeName) {
            if ($info->name == $routeName) {
                header("Location:{$info->uri}");
            }
        }, $route), Route::$routes);
    }
}

if (! function_exists('errors')) {
    function errors()
    {
        $session = App::getInstance()->resolve('session');
        return $session->getErrors('errors');
    }
}
