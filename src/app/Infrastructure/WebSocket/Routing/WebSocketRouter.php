<?php

namespace App\Infrastructure\WebSocket\Routing;

use InvalidArgumentException;

class WebSocketRouter
{
    /**
     * @var array<string, class-string>
     */
    private static array $routes = [];

    /**
     * @param string $uri
     * @param string $controller
     * @return void
     * @throws InvalidArgumentException
     */
    public static function ws(string $uri, string $controller): void
    {
        if (!is_string($uri) || !class_exists($controller)) {
            throw new InvalidArgumentException('Неверный тип переданного аргумента');
        }
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
