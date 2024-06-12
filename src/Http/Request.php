<?php

declare(strict_types=1);

namespace Src\Http;

class Request
{
    public $parameters;
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function uri()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function QueryParams()
    {
        return $_GET;
    }

    public static function BodyParams()
    {
        return $_POST;
    }
}