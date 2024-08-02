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
     */
    #[NoReturn] public static function send(): void
    {
        if (!Router::routeExists()) {
            header("HTTP/1.1 404 Not Found");
            return;
        }
        header('Content-Type: application/json');
        if (Router::routeIsDirectory()) {
            $files = Router::getUrlFiles();
            header("Content-disposition: attachment; filename=\"" . basename(Router::getCurrentRoute()) . "\"");
            if (count($files) === 3) {
                echo file_get_contents(Router::getCurrentRoute() . '/' . $files[2]);
            } else {
                echo '[';
                foreach ($files as $route) {
                    if (is_dir(Router::getCurrentRoute() . '/' . $route)) {
                        continue;
                    } else if ($route != "." && $route != "..") {

                        echo file_get_contents(Router::getCurrentRoute() . '/' . $route);
                    }
                }
                echo ']';
            }

        } else {
            echo file_get_contents(Router::getCurrentRoute());
        }
    }

    /**
     * send response as [no content]
     * @return void
     */
    #[
        NoReturn] public static function noContentSend(): void
    {
        header("HTTP/1.1 201 Created");
        die();
    }
}