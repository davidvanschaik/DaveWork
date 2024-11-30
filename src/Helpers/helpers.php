<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use Src\Core\App;
use Src\Routing\RouteRegistration as Route;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
$dotenv->load();

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