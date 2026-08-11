<?php
namespace Iran\Controllers;


use Iran\Core\Response;
use Iran\Models\ProvincesModel;
use PDOException;

class ProvincesController{
    private ProvincesModel $model;
    public function __construct(ProvincesModel $model){
        $this->model = $model;
    }

    public function index(){
        $provinces = $this->model->getAll();
        return Response::json($provinces , 200 , "success");
    }
    public function getById(int $id){
        $provinces = $this->model->getProvinces($id);
        if(!$provinces){
            return Response::json(null, 404 , "provinces not found");
        }
        return Response::json($provinces , 200 , "success");
    }

    public function create(array $data){
        try{
            $provinceId = $this->model->createProvinces($data['name']);
            return Response::json($provinceId , 200 , "success");
        }catch(PDOException $e){
            return Response::json(null, 500 , "failed to create province");
        }
    }
}
