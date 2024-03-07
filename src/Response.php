<?php
namespace Alirezamires\DummyServer;
class Response
{
    public static function send()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $routes = self::getRoute();
        var_dump($routes);
        if (array_key_exists($uri, $routes)) {
            header('Content-Type: application/json');
            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                self::update($routes[$uri]);
            }
            if(is_dir($routes[$uri])){
                $files = scandir($routes[$uri]);
                header("Content-disposition: attachment; filename=\"" . basename($routes[$uri]) . "\"");
                if(count($files) === 3){
                    echo file_get_contents($routes[$uri].'/'.$files[2]);
                }else{
                    echo '[';
                    foreach ($files as $route) {
                        if (is_dir($routes[$uri].'/'.$route)) {
                            continue;
                        } else if ($route != "." && $route != "..") {

                            echo file_get_contents($routes[$uri].'/'.$route);
                        }
                    }
                    echo ']';
                }

            }else{
                echo file_get_contents($routes[$uri]);
            }
        } else {
            header("HTTP/1.1 404 Not Found");
        }
        die();
    }

    public static function noContentSend()
    {
        header("HTTP/1.1 201 Created");
        die();
    }



    /**
     * @return array
     */
    public static function getRoute(): array
    {
        $routes = array_map(function ($item) {
            return [str_replace("\\", '/', str_replace('.json', '', str_replace(realpath(root_dir()  . '/dummy-data/'), '', $item))) => $item];
        }, Helper::getDirContents(root_dir() . '\\dummy-data\\'));

        return array_merge(...$routes);
    }

    /**
     * @param $routes
     * @return void
     */
    private static function update($routes): void
    {
        try {
            file_put_contents($routes, json_encode(json_decode(file_get_contents("php://input"))));
        } catch (JsonException $exception) {

        }
    }
}