<?php

declare(strict_types=1);

namespace Src\Foundation\Routing;

use Src\Http\Request;

require $_SERVER['DOCUMENT_ROOT'] . '/routes/Routes.php';

class Route
{
    public static array|null $routes = null;

    private static function Register(string $method, string $uri, array | callable $action)
    {
        return self::$routes[$method][$uri] = new Register($method, $uri, $action, new Request);
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
//        echo json_encode(self::$routes);

        if (! array_key_exists($method, self::$routes)) {
            return null;
        }

        foreach (self::$routes[$method] as $route) {

            $serverPartials = Register::extractPartials($uri);
            $routePartials = $route->getPartials();

            if (count($routePartials) !== count($serverPartials)) {
                http_response_code(404);
            }

            $routeUriParts = [];
            foreach ($routePartials as $index => $part) {
               if ($part['isParameter'] === true) {
                   $routeUriParts[] = $serverPartials[$index]['data'];
                   $route->request->parameters = $serverPartials[$index]['data'];
                   continue;
               }
               $routeUriParts[] = $part['data'];
            }
            $routeUri = '/' . implode('/', $routeUriParts);

            $route->uri = $routeUri;
            return $route;

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