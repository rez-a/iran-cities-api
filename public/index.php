<?php

require_once "../vendor/autoload.php";

use Iran\Core\Router;
use Iran\Core\Request;
use Iran\Database\Database;
use Iran\Models\CitiesModel;
use Iran\Controllers\CitiesController;

$router = new Router();
$request = new Request();
$database = new Database();
$connection = $database->getConnection();
$model = new CitiesModel($connection);
$controller = new CitiesController($model);

require_once "../routes/api.php";


echo $router->dispatch($request);
