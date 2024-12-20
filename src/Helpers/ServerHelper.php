<?php

namespace Src\Helpers;

class ServerHelper
{
    public static function terminateServer(string $fileName): void
    {
        pcntl_signal(SIGINT, function () use ($fileName) {
            self::clear($fileName);
            exit(0);
        });
    }

    public static function clear(string $file): void
    {
        file_put_contents($file, '');
    }
}