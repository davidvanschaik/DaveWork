<?php

namespace Src\Console;

class Response
{
//    font colors for CLI;
    public const RESET = "\033[0m";
    public const BLACK = "\033[0;30m";
    public const RED = "\033[0;31m";
    public const GREEN = "\033[0;32m";
    public const YELLOW = "\033[0;33m";
    public const BLUE = "\033[0;34m";
    public const CYAN = "\033[0;36m";
    public const WHITE = "\033[0;37m";

//    background colors for command line interface
    public const RED_BG = "\033[41m";
    public const GREEN_BG = "\033[42m";
    public const BLUE_BG = "\033[104m";

    public static function echo(string $color, string $message): string
    {
        return self::{$color} . $message . self::RESET . PHP_EOL;
    }

    public static function block(string $color, string $info): string
    {
        return self::{$color} . $info . PHP_EOL;
    }

}