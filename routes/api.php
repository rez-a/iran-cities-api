<?php
use Iran\Controllers\CitiesController;
use Iran\Controllers\ProvincesController;


$routes = [['method' => 'GET' , 'path' => '/api/v1/cities' , 'handler'=>[CitiesController::class , 'index']],
    ['method' => 'GET' , 'path' => '/api/v1/cities/{id}' , 'handler'=>[CitiesController::class , 'show']],
    ['method' => 'GET' , 'path' => '/api/v1/provinces' , 'handler'=>[ProvincesController::class , 'index']] ];



foreach ($routes as $route) {
    $router->addRoute($route['method'], $route['path'], $route['handler']);
}
