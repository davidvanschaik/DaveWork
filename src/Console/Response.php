<?php

namespace Src\Console;

use Src\Console\Response as CLI;

class Response
{
//    font colors for CLI;
    public const RESET = "\033[0m";
    public const RED = "\033[0;31m";
    public const GREEN = "\033[0;32m";
    public const YELLOW = "\033[0;33m";
    public const GRAY = "\033[90m";

//    background colors for command line interface
    public const BLUE_BG = "\033[104m";
    public const RED_BG = "\033[41m";
    public const RESET_BG = "\033[0m";

    public static function error(): false
    {
        echo self::block() . self::echo("RED", " Invalid command given. \n \n");
        echo '    More info: ' . self::echo('GREEN', "'php commander help' \n \n");
        exit;
    }

    public static function echo(string $color, string $message): string
    {
        return self::{$color} . $message . self::RESET;
    }

    public static function block(string $message = 'INFO', string $color = 'BLUE_BG'): string
    {
        return "\n    " . self::{$color} . " $message " . self::RESET;
    }

    public static function invalidCommand(string $message): void
    {
        echo self::block('ERROR', 'RED_BG') . "$message \n \n";
        self::errorResponseCLI();
        exit;
    }

    public static function errorResponseCLI(): void
    {
        error_reporting(E_ERROR);
        trigger_error("", E_USER_ERROR);
    }

    public static function showCommandInfo(array $info, string $category = ''): void
    {
        echo CLI::YELLOW . "    $category \n" . CLI::RESET;
        foreach ($info as $key => $i) {
            echo self::GREEN . "     $key" . self::RESET;
            echo str_repeat(' ', 20 - strlen($key)) . "$i \n";
        }
    }

    public static function infoError(int $key): void
    {
        echo CLI::block('ERROR', 'RED_BG') . " Invalid command given. \n";
        self::showCommandInfo(self::commandInfo($key));
        self::errorResponseCLI();
        exit;
    }

    public static function commandInfo(mixed $key = ''): array
    {
        $commands = require __DIR__ . '/../../config/commands.php';
        return $commands[$key] ?? $commands;
    }

    public static function help(array $type): void
    {
        $info = self::commandInfo();
        for ($x = 0; $x < 3; $x++) {
            self::showCommandInfo($info[$x], $type[$x]);
        }
        exit;
    }
}