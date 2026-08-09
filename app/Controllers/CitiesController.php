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
    public function getById($id){
        $city = $this->model->getCity($id);
        if(!$city){
            return Response::json(null, 404 , "city not found");
        }
        return Response::json($city, 200 , "success");
    }
}
