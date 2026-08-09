<?php
namespace Iran\Controllers;


use Iran\Core\Response;
use Iran\Models\ProvincesModel;

class ProvincesController{
    private ProvincesModel $model;
    public function __construct(ProvincesModel $model){
        $this->model = $model;
    }

    public function index(){
        $provinces = $this->model->getAll();
        return Response::json($provinces , 200 , "success");
    }
}
