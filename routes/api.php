<?php
use Iran\Controllers\CitiesController;

$router->addRoute(
    'GET',
        '/api/v1/cities',
    [$controller , 'index']
);
