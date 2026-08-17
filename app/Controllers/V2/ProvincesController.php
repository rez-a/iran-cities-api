<?php
namespace Iran\Controllers\V2;


use Iran\Core\Request;
use Iran\Core\Response;
use Iran\Models\ProvincesModel;
use Iran\Services\FieldFilter;
use PDOException;

class ProvincesController{
    private ProvincesModel $model;
    private FieldFilter $fieldFilter;
    private array $allowedFields = ['id' , 'name' ];
    public function __construct(ProvincesModel $model , FieldFilter $fieldFilter){
        $this->model = $model;
        $this->fieldFilter = $fieldFilter;
    }

    public function index( Request $request,int $page = 1, int $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $provinces = $this->model->getPaginated($limit, $offset);
        $totalProvinces = $this->model->getTotal();
        $lastPage = (int) ceil($totalProvinces / $limit);
        $fields = $request->query()['fields'] ?? null;
        $provinces = $this->fieldFilter->filter($provinces, $fields , $this->allowedFields);
        return Response::json([
            'items'=>$provinces,
            'pagination' => [
                'total' => $totalProvinces,
                'current_page' => $page,
                'last_page' => $lastPage,
                'per_page' => $limit,
            ]
        ], 200 , "success");
    }
    public function getById(Request $request , int $id){
        $province = $this->model->getProvinces($id);
        if(!$province){
            return Response::json(null, 404 , "provinces not found");
        }
        $field = $request->query()['fields'] ?? null;
        $province = $this->fieldFilter->filter([$province] , $field , $this->allowedFields);
        return Response::json($province , 200 , "success");
    }

    public function create(array $data){
        try{
            $provinceId = $this->model->createProvinces($data['name']);
            return Response::json($provinceId , 201 , "success");
        }catch(PDOException $e){
            return Response::json(null, 500 , "failed to create province");
        }
    }

    public  function update(int $id , array $data)
    {
        try{
            $provinceId = $this->model->updateProvinces($id, $data['name']);
            if($provinceId === false){
                return Response::json(null, 404 , "province not found");
            }
            return Response::json(['id'=>$provinceId] , 200 , "province updated successfully");
        }catch (PDOException $e){
            return Response::json(null, 500 , "failed to update province");
        }

    }


    public  function delete(int $id)
    {
        try{
            $provinceId = $this->model->deleteProvinces($id);
            if($provinceId === false){
                return Response::json(null, 404 , "province not found");
            }
            return Response::json(['id'=>$provinceId] , 200 , "province deleted successfully");
        }catch (PDOException $e){
            return Response::json(null, 500 , "failed to delete province");
        }

    }
}
