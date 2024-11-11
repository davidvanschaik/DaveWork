<?php

$log = sprintf(
    "%s %s %s %s\n",
    date('Y-m-d'),
    date('H:i:s'),
    $_SERVER['REQUEST_METHOD'],
    $_SERVER['REQUEST_URI'],
);
file_put_contents(__DIR__ . '/../../../../storage/logs/server.log', $log, FILE_APPEND);
