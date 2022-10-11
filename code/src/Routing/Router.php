<?php
declare(strict_types=1);

namespace ApiExample\Routing;

use ApiExample\Exceptions\AppException;
use ApiExample\Exceptions\NotFoundException;
use ApiExample\Registry;
use ApiExample\RegistryKeys;

class Router
{
    protected static array $routes = [];


    public static function get(string $url, callable|array $callback): void
    {
        self::$routes[] = new Route('GET', $url, $callback);
    }

    public static function post(string $url, callable|array $callback): void
    {
        self::$routes[] = new Route('POST', $url, $callback);
    }

    public static function put($url, callable|array $callback): void
    {
        self::$routes[] = new Route('PUT', $url, $callback);
    }

    public static function delete($url, callable|array $callback): void
    {
        self::$routes[] = new Route('DELETE', $url, $callback);
    }

    /**
     * @throws NotFoundException
     * @throws AppException
     */
    public static function start(): void
    {
        foreach (self::$routes as $route) {
            /**
             * @var $route Route
             */
            if (!$route->matchRequest(Registry::get(RegistryKeys::REQUEST))) {
                continue;
            }

            $route->run();
            return;
        }

        throw new NotFoundException();
    }
}