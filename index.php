<?php 
$name = 'requests/request-'.date('y-m-d-H-i-s').'.json';
$data = json_encode(['get'=>$_GET,'post'=>$_POST,'cookie'=>$_COOKIE,'headers'=>getallheaders(),'uri'=>$_SERVER['REQUEST_URI']]);
file_put_contents($name ,$data);
$routes = [
  "/api/v1/bloks/apps/com.bloks.www.caa.login.home_template"=>file_get_contents(__dir__ .'/dummy-data/login-t.json'),
  "/about",
  "/contact" => "contact.php",
];
var_dump($_SERVER['REQUEST_URI']);
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
foreach ($routes as $pattern => $script) {
  if (preg_match($pattern, $uri)) {
    echo $script;
    break;
  }
}