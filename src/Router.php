<?php

namespace Alirezamires\DummyServer;

class Router
{
    public static function getUrlFiles(): bool|array
    {
        return scandir(self::getCurrentRoute());
    }

    public static function routeIsDirectory(): bool
    {
        return is_dir(self::getCurrentRoute());
    }

    public static function routeExists(): bool
    {
        return array_key_exists(self::getURL(), self::getRoute());
    }

    public static function getCurrentRoute()
    {
        return self::getRoute()[self::getURL()];
    }

    /**
     * get route from folder.
     */
    public static function getRoute(): array
    {
        return once(function () {
            $routes = array_map(function ($file) {
                $route = str_replace('\\', '/', str_replace('.json', '', str_replace(realpath(root_dir() . '/dummy-data/'), '', $file)));
                $route .= str_ends_with($route, '/') ? '' : '/';

                return [$route => $file];
            }, Helper::getDirContents(root_dir() . '\\dummy-data\\'));

            return array_merge(...$routes);
        });
    }

    /**
     * get url from request.
     */
    public static function getURL(): string|array|int|false|null
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (!str_ends_with($uri, '/')) {
            $uri .= '/';
        }

        return $uri;
    }
}
