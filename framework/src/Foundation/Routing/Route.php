<?php

declare(strict_types=1);

namespace Src\Foundation\Routing;

class Route
{
    public static array|null $routes = null;

    private static function Register(string $method, string $uri, array | callable $action)
    {
        return self::$routes[$method][$uri] = new Register($method, $uri, $action);
    }

    public static function get(string $uri, array | callable $action)
    {
        return self::Register('GET', $uri, $action);
    }

    public static function post(string $uri, array | callable $action)
    {
        return self::Register('POST', $uri, $action);
    }

    public static function delete(string $uri, array | callable $action)
    {
        return self::Register('DELETE', $uri, $action);
    }

    public static function put(string $uri, array | callable $action)
    {
        return self::Register('PUT', $uri, $action);
    }

    public static function findRoute(string $method, string $uri)
    {
        if (! self::$routes) {
            require_once($_SERVER['DOCUMENT_ROOT'] . '/routes/Routes.php');
        }

        foreach (self::$routes as $route) {
            return $route[$uri];
        }
        return null;
    }

//    public static function findRoute(string $method, string $uri): Register | null
//    {
//        if (! self::$routes) {
//            require_once($_SERVER['DOCUMENT_ROOT'] . '/routes/Routes.php');
//        }
//
//        if (!array_key_exists($method, self::$routes)) {
//            return null;
//        }
//
//        $uriPartials = Register::extractPartials($uri);
//
//        $found = null;
//
//        foreach (self::$routes[$method] as $route) {
//            if ($found) {
//                break;
//            }
//
//            $partials = $route->getPartials();
//
//            foreach ($partials as $key => $part) {
//                if ($part['isParameter']) {
//                    continue;
//                }
//
////                var_dump(array_key_exists(($key + 1), $partials));
//                if ($part['data'] != $uriPartials[$key]['data']) {
//                    break;
//                } else if (!array_key_exists(($key + 1), $partials) && count($uriPartials) === count($partials)) {
//                    $found = $route;
//                }
//            }
//        }
//
//        return $found;
//    }
}