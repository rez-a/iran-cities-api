<?php
namespace Iran\Controllers;

use Iran\Core\Response;

class CitiesController{

    public function index()
    {
        return Response::json([] , 200 , 'success');
    }
}
