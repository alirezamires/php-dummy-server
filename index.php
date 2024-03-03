<?php 
$name = 'requests/request-'.date('y-m-d-H-i-s').'.json';
$data = json_encode(['get'=>$_GET,'post'=>$_POST,'cookie'=>$_COOKIE,'headers'=>getallheaders(),'uri'=>$_SERVER['REQUEST_URI']]);
file_put_contents($name ,$data);
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

function getDirContents($dir, &$results = array()) {
    $files = scandir($dir);

    foreach ($files as $key => $value) {
        $path = realpath($dir . DIRECTORY_SEPARATOR . $value);
        if (!is_dir($path)) {
            $results[] = $path;
        } else if ($value != "." && $value != "..") {
            getDirContents($path, $results);
            $results[] = $path;
        }
    }

    return array_filter($results,static function ($item){
        return filesize($item) > 0;
    });
}
$routes = array_map(function ($item){
    return [str_replace("\\",'/',str_replace('.json','',str_replace(realpath(__dir__.'/dummy-data/'),'',$item)))=>$item];
},getDirContents(__dir__ .'/dummy-data/'));
$routes = array_merge(...$routes);
if(array_key_exists($uri,$routes)){
    header('Content-Type: application/json');
    echo file_get_contents($routes[$uri]);
}else{
    header("HTTP/1.1 404 Not Found");
}
