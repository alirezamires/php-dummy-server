<?php

class Response
{
    public static function send()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $routes = self::getRoute();
        if(array_key_exists($uri,$routes)){
            header('Content-Type: application/json');
            echo file_get_contents($routes[$uri]);
        }else{
            header("HTTP/1.1 404 Not Found");
        }
    }
    private static function getDirContents($dir, &$results = array()) {
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

        return array_filter($results,static function ($item){
            return filesize($item) > 0;
        });
    }

    /**
     * @return array
     */
    public static function getRoute()
    {
        $routes = array_map(function ($item) {
            return [str_replace("\\", '/', str_replace('.json', '', str_replace(realpath(__dir__ . '/dummy-data/'), '', $item))) => $item];
        }, self::getDirContents(__dir__ . '/dummy-data/'));

        return array_merge(...$routes);
    }
}