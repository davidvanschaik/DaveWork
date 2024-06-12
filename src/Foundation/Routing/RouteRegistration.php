<?php

declare(strict_types=1);

namespace Src\Foundation\Routing;

class RouteRegistration
{
    /**
     * @var array<string, array<int, Route>>
     */
    public static array $routes = [];

    private static function register(string $method, string $uri, array|callable $action): Route
    {
        return self::$routes[$method][$uri] = new Route($method, $uri, $action);
    }

    public static function get(string $uri, array|callable $action): Route
    {
        return self::register('GET', $uri, $action);
    }

    public static function post(string $uri, array|callable $action): Route
    {
        return self::register('POST', $uri, $action);
    }

    public static function delete(string $uri, array|callable $action): Route
    {
        return self::register('DELETE', $uri, $action);
    }

    public static function put(string $uri, array|callable $action): Route
    {
        return self::register('PUT', $uri, $action);
    }

    public function findRoute(string $method, string $serverUri): ?Route
    {
        if (!array_key_exists($method, self::$routes)) {
            return null;
        }

        return $this->doFindRoute($method, $serverUri);
    }

    private function doFindRoute(string $method, string $serverUri): ?Route
    {
        foreach (self::$routes[$method] as $route) {
            if ($route->matches($serverUri)) {
                return $route;
            }
        }
        return null;
    }
}