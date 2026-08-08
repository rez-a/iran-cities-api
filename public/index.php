<?php

require_once "../vendor/autoload.php";

use Iran\Core\Router;
use Iran\Core\Request;
use Iran\Core\Container;



$container = new Container();
$router = new Router($container);
$request = new Request();


require_once "../routes/api.php";


echo $router->dispatch($request);
