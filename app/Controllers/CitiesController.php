<?php
namespace Iran\Controllers;

use Iran\Core\Response;
use Iran\Models\CitiesModel;

class CitiesController{
    private CitiesModel $model;
    public function __construct(CitiesModel $model){
        $this->model = $model;
    }
    public function index()
    {
        $cities = $this->model->getAll();
        return Response::json($cities , 200 , "success");
    }
    public function show($id){
        return Response::json(["id" => $id], 200 , "success");
    }
}
