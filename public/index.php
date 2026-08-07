<?php

require_once "../vendor/autoload.php";

use Iran\Core\Router;

$router = new Router();
require_once "../routes/api.php";

$request = [
    "method" => $_SERVER['REQUEST_METHOD'],
    "path" => parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
];

echo $router->dispatch($request);
