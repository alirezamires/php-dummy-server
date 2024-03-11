<?php
namespace Alirezamires\DummyServer;
class Request
{
    static function save()
    {
        $name = root_dir() . '/requests-logs/request-' . date('y-m-d-H-i-s') . '.json';
        $data = json_encode(['get' => $_GET, 'post' => $_POST, 'cookie' => $_COOKIE, 'headers' => getallheaders(), 'uri' => $_SERVER['REQUEST_URI']]);
        file_put_contents($name, $data);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            self::storeAsJson();
        }
    }

    static function storeAsJson()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if (is_numeric(basename($uri))) {
            $uri = parse_url(str_replace('/'.basename($uri),'',$_SERVER['REQUEST_URI']), PHP_URL_PATH);
        }
        if (!is_dir(root_dir() . '/dummy-data/' . $uri)) {
            mkdir(root_dir() . '/dummy-data/' . $uri);
        }
        $path = realpath(root_dir() . '/dummy-data/' . $uri);
        $files = scandir($path);
        $file = (count($files) - 1) . '.json';
        file_put_contents($path . '/' . $file, json_encode($_POST));
        Response::noContentSend();
    }
}