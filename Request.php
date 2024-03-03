<?php

class Request
{
    static function save()
    {
        $name = 'requests/request-'.date('y-m-d-H-i-s').'.json';
        $data = json_encode(['get'=>$_GET,'post'=>$_POST,'cookie'=>$_COOKIE,'headers'=>getallheaders(),'uri'=>$_SERVER['REQUEST_URI']]);
        file_put_contents($name ,$data);
    }
}