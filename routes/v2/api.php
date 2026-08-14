<?php


use Iran\Controllers\V2\CitiesController;
use Iran\Controllers\V2\ProvincesController;

$routes = [
    ['method' => 'GET', 'path' => '/api/v2/cities', 'handler' => [CitiesController::class, 'index']],
    ['method' => 'GET', 'path' => '/api/v2/cities/{id}', 'handler' => [CitiesController::class, 'getById']],
    ['method' => 'POST', 'path' => '/api/v2/cities', 'handler' => [CitiesController::class, 'create']],
    ['method' => 'PUT', 'path' => '/api/v2/cities/{id}', 'handler' => [CitiesController::class, 'update']],
    ['method' => 'DELETE', 'path' => '/api/v2/cities/{id}', 'handler' => [CitiesController::class, 'delete']],
    ['method' => 'GET', 'path' => '/api/v2/provinces', 'handler' => [ProvincesController::class, 'index']],
    ['method' => 'GET', 'path' => '/api/v2/provinces/{id}', 'handler' => [ProvincesController::class, 'getById']],
    ['method' => 'POST', 'path' => '/api/v2/provinces', 'handler' => [ProvincesController::class, 'create']],
    ['method' => 'PUT', 'path' => '/api/v2/provinces/{id}', 'handler' => [ProvincesController::class, 'update']],
    ['method' => 'DELETE', 'path' => '/api/v2/provinces/{id}', 'handler' => [ProvincesController::class, 'delete']]
];


foreach ($routes as $route) {
    $router->addRoute($route['method'], $route['path'], $route['handler']);
}
