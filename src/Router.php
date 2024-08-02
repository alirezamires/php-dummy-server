<?php

namespace Alirezamires\DummyServer;

class Router
{
    public static function getUrlFiles(): bool|array
    {
        return scandir(self::getUri());
    }

    public static function routeIsDirectory(): bool
    {
        return is_dir(self::getUri());
    }

    public static function routeExists(): bool
    {
        return array_key_exists(self::getURL(), self::getRoute());
    }

    public static function getCurrentRoute()
    {
        if (!self::routeExists()) {
            return null;
        }
        return self::getRoute()[self::getURL()];
    }

    /**
     * get route from folder
     *
     * @return array
     */
    public static function getRoute(): array
    {
        return once(function () {
            $routes = array_map(function ($file) {
                $route = str_replace("\\", '/', str_replace('.json', '', str_replace(realpath(root_dir() . '/dummy-data/'), '', $file)));
                $route .= str_ends_with($route, '/') ? '' : '/';
                return [$route => $file];
            }, Helper::getDirContents(root_dir() . '\\dummy-data\\'));

            return array_merge(...$routes);
        });
    }


    /**
     * get url from request
     *
     * @return array|false|int|string|null
     */
    public static function getURL(): string|array|int|null|false
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (!str_ends_with($uri, '/')) {
            $uri .= '/';
        }
        return $uri;
    }

    /**
     * @return mixed|string
     */
    public static function getUri(): mixed
    {
        return self::getCurrentRoute() ?? root_dir() . '\\dummy-data\\' . self::getURL();
    }
}