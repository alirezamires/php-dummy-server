<?php

namespace Alirezamires\DummyServer;

use JetBrains\PhpStorm\NoReturn;
use ZipArchive;

/**
 *
 */
class Request
{
    /**
     * store data send log
     * @return void
     */
    static function receive(): void
    {
        $time = date('y-m-d-H-i-s');
        $zip = new ZipArchive;
        $open_status = $zip->open(root_dir() . '/requests-logs/log.zip', ZipArchive::CREATE);
        if ($open_status !== true) {
            return;
        }
        $file_path = root_dir() . '/requests-logs/request-' . '-' . $time . '.json';
        $data = json_encode([
            'get' => $_GET,
            'post' => $_POST,
            'cookie' => $_COOKIE,
            'headers' => getallheaders(),
            'uri' => $_SERVER['REQUEST_URI'],
            'server' => $_SERVER,
            'memory' => Helper::sizeToHumanConvert(memory_get_usage())
        ]);
        file_put_contents($file_path, $data);
        $zip->addFile($file_path, 'request-' . $time . '.json');
        $zip->close();
        unlink($file_path);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            self::storeAsJson();
        }
    }

    /**
     * store send post date [Create Request]
     * @return void
     */
    #[NoReturn] static function storeAsJson(): void
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (is_numeric(basename($uri))) {
            $uri = parse_url(str_replace('/' . basename($uri), '',
                $_SERVER['REQUEST_URI']), PHP_URL_PATH);
        }
        if (!is_dir(root_dir() . '/dummy-data/' . $uri)) {
            mkdir(root_dir() . '/dummy-data/' . $uri, recursive: true);
        }
        $path = realpath(root_dir() . '/dummy-data/' . $uri);
        $files = scandir($path);
        $file = (count($files) - 1) . '.json';
        file_put_contents($path . '/' . $file, json_encode($_POST));
        echo json_encode([...$_POST, 'id' => (count($files) - 1)]);
        Response::noContentSend();
    }
}