<?php

namespace Alirezamires\DummyServer;

use JetBrains\PhpStorm\NoReturn;
use JsonException;

/**
 *  make response instance
 */
class Response
{
    /**
     * send response to client side
     *
     * @return void
     * @throws JsonException
     */
    #[NoReturn] public static function send(): void
    {
        self::setHeaders();
        $uri = self::getURL();
        $routes = self::getRoute();
        if (array_key_exists($uri, $routes)) {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                self::update($routes[$uri]);
            }
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
                self::delete($routes[$uri]);
            }
            if (is_dir($routes[$uri])) {
                $files = scandir($routes[$uri]);
                header("Content-disposition: attachment; filename=\"" . basename($routes[$uri]) . "\"");
                if (count($files) === 3) {
                    echo file_get_contents($routes[$uri] . '/' . $files[2]);
                } else {
                    echo '[';
                    foreach ($files as $route) {
                        if (is_dir($routes[$uri] . '/' . $route)) {
                            continue;
                        } else if ($route != "." && $route != "..") {

                            echo file_get_contents($routes[$uri] . '/' . $route);
                        }
                    }
                    echo ']';
                }

            } else {
                echo file_get_contents($routes[$uri]);
            }
        } else {
            header("HTTP/1.1 404 Not Found");
        }
        die();
    }

    /**
     * send response as [no content]
     * @return void
     */
    #[NoReturn] public static function noContentSend(): void
    {
        header("HTTP/1.1 201 Created");
        die();
    }


    /**
     * get route from folder
     *
     * @return array
     */
    private static function getRoute(): array
    {
        $routes = array_map(function ($file) {
            $route = str_replace("\\", '/', str_replace('.json', '', str_replace(realpath(root_dir() . '/dummy-data/'), '', $file)));
            $route .= str_ends_with($route, '/') ? '' : '/';
            return [$route => $file];
        }, Helper::getDirContents(root_dir() . '\\dummy-data\\'));

        return array_merge(...$routes);
    }

    /**
     * update date was stored in folder.
     *
     * @param $route
     *
     * @return void
     */
    private static function update($route): void
    {
        file_put_contents($route, json_encode(json_decode(file_get_contents("php://input"))));
    }

    /**
     * remove stored json file
     *
     * @param $routes
     *
     * @return void
     */
    private static function delete($routes): void
    {
        unlink($routes);
        self::noContentSend();
    }

    /**
     * get url from request
     *
     * @return array|false|int|string|null
     */
    private static function getURL(): string|array|int|null|false
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (!str_ends_with($uri, '/')) {
            $uri .= '/';
        }
        return $uri;
    }

    /**
     * add headers to response
     *
     * @return void
     */
    private static function setHeaders()
    {

    }
}