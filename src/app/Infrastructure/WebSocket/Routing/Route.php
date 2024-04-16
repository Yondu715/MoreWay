<?php

namespace App\Infrastructure\WebSocket\Routing;

class Route
{
    /**
     * @var array<string, class-string>
     */
    private static array $routes = [];

    /**
     * @param string $uri
     * @param string $controller
     * @return void
     */
    public static function ws(string $uri, string $controller): void
    {
        self::$routes[$uri] = $controller;
    }


    /**
     * @return array<string, class-string>
     */
    public static function getRoutes(): array
    {
        return self::$routes;
    }
}
