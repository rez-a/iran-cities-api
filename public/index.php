<?php

require_once "../vendor/autoload.php";

use Iran\Core\Router;
use Iran\Core\Request;

$router = new Router();
$request = new Request();
require_once "../routes/api.php";


echo $router->dispatch($request);
