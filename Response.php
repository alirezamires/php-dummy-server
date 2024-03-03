<?php

class Response
{
    public static function send()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $routes = self::getRoute();
        if (array_key_exists($uri, $routes)) {
            header('Content-Type: application/json');

            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                self::update($routes[$uri]);
            }
            if(is_dir($routes[$uri])){
                $files = scandir($routes[$uri]);
                header("Content-disposition: attachment; filename=\"" . basename($routes[$uri]) . "\"");
                echo '[';
                foreach ($files as $route) {
                    if (is_dir($routes[$uri].'/'.$route)) {
                    continue;
                    } else if ($route != "." && $route != "..") {

                       echo file_get_contents($routes[$uri].'/'.$route);
                    }
                }
                echo ']';
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

    private static function getDirContents($dir, &$results = array())
    {
        $files = scandir($dir);

        foreach ($files as $value) {
            $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
            if (!is_dir($path)) {
                $results[] = $path;
            } else if ($value != "." && $value != "..") {
                self::getDirContents($path, $results);
                $results[] = $path;
            }
        }

        return array_filter($results, static function ($item) {
            return filesize($item) > 0;
        });
    }

    /**
     * @return array
     */
    public static function getRoute(): array
    {
        $routes = array_map(function ($item) {
            return [str_replace("\\", '/', str_replace('.json', '', str_replace(realpath(__dir__ . '/dummy-data/'), '', $item))) => $item];
        }, self::getDirContents(__dir__ . '/dummy-data/'));

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