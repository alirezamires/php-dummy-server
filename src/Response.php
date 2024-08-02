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
        header('Content-Type: application/json');
        if (Router::routeIsDirectory()) {
            $files = Router::getUrlFiles();
            if (count($files) === 3) {
                echo file_get_contents(Router::getUri() . '/' . $files[2]);
            } else {
                $last_key = array_key_last($files);
                echo '[';
                foreach ($files as $index => $file) {
                    if (is_dir(Router::getUri() . '/' . $file)) {
                        continue;
                    } else if ($file != "." && $file != "..") {
                        echo file_get_contents(Router::getUri() . '/' . $file);
                        if($last_key !== $index){
                            echo ',';
                        }
                    }
                }
                echo ']';
            }
            return;
        }
        if (!Router::routeExists()) {
            header("HTTP/1.1 404 Not Found");
            return;
        }
        echo file_get_contents(Router::getCurrentRoute());
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