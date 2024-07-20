<?php

declare(strict_types=1);

use JetBrains\PhpStorm\NoReturn;
use Src\Core\App;
use Src\Http\Request;
use Src\Routing\RouteRegistration as Route;
use Src\View\View;

#[NoReturn]
function dd(mixed $var): void
{
    echo "<pre>";
    var_dump($var);
    echo "</pre>";

    die();
}

function view(string $templateName, array $data = []): string
{
    $view = App::getInstance()->resolve('view');
    return $view->render($templateName, $data);
}

function redirect(string $routeName): void
{
    $request = App::getInstance()->resolve('request');
    if ($routeName == 'back') {
        header("Location:" . $request->uri());
    }

    foreach (Route::$routes as $route) {
       foreach ($route as $info) {
           if ($info->name == $routeName) {
               header("Location:{$info->uri}");
           }
       }
    }
}

function errors()
{
    $session = App::getInstance()->resolve('session');
    return $session->getErrors('errors');
}