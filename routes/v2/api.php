<?php


use Iran\Controllers\V2\CitiesController;
use Iran\Controllers\V2\ProvincesController;
use Iran\Controllers\V2\AuthController;

$routes = [
    ['method' => 'GET', 'path' => '/api/v2/cities', 'handler' => [CitiesController::class, 'index'] , 'auth' => true , "role"=>null],
    ['method' => 'GET', 'path' => '/api/v2/cities/{id}', 'handler' => [CitiesController::class, 'getById'] , 'auth' => true , "role"=>null],
    ['method' => 'POST', 'path' => '/api/v2/cities', 'handler' => [CitiesController::class, 'create'] , 'auth' => true , "role"=>"admin"],
    ['method' => 'PUT', 'path' => '/api/v2/cities/{id}', 'handler' => [CitiesController::class, 'update'] , 'auth' => true , "role"=>"admin"],
    ['method' => 'DELETE', 'path' => '/api/v2/cities/{id}', 'handler' => [CitiesController::class, 'delete'] , 'auth' => true  , "role"=>"admin"],
    ['method' => 'GET', 'path' => '/api/v2/provinces', 'handler' => [ProvincesController::class, 'index'] , 'auth' => true , "role"=>null],
    ['method' => 'GET', 'path' => '/api/v2/provinces/{id}', 'handler' => [ProvincesController::class, 'getById'] , 'auth' => true , "role"=>null],
    ['method' => 'POST', 'path' => '/api/v2/provinces', 'handler' => [ProvincesController::class, 'create'] , 'auth' => true , "role"=>"admin"],
    ['method' => 'PUT', 'path' => '/api/v2/provinces/{id}', 'handler' => [ProvincesController::class, 'update'] , 'auth' => true , "role"=>"admin"],
    ['method' => 'DELETE', 'path' => '/api/v2/provinces/{id}', 'handler' => [ProvincesController::class, 'delete'] , 'auth' => true , "role"=>"admin"],
    ['method' => 'POST', 'path' => '/api/v2/login', 'handler' => [AuthController::class, 'login'] , 'auth' => false , "role"=>null],

];


foreach ($routes as $route) {
    $router->addRoute($route['method'], $route['path'], $route['handler'] , $route['auth'] , $route['role']);
}
