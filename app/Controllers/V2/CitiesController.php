<?php
namespace Iran\Controllers\V2;

use Iran\Core\Response;
use Iran\Models\CitiesModel;
use Iran\Services\FieldFilter;
use PDOException;
use Iran\Core\Request;

class CitiesController{
    private CitiesModel $model;
    private FieldFilter $fieldFilter;
    private array $allowedFields = ['id' , 'name' , 'province_id'];
    public function __construct(CitiesModel $model , FieldFilter $fieldFilter){
        $this->model = $model;
        $this->fieldFilter = $fieldFilter;
    }

    public function index(Request $request, int $page = 1, int $limit = 10)
    {
        $offset = ($page - 1) * $limit;
        $cities = $this->model->getPaginated($limit, $offset);
        $totalCities = $this->model->getTotal();
        $lastPage = (int) ceil($totalCities / $limit);
        $field = $request->query()['fields'] ?? null;
        $cities = $this->fieldFilter->filter($cities , $field , $this->allowedFields);
        return Response::json([
            'items'=>$cities,
            'pagination' => [
                'total' => $totalCities,
                'current_page' => $page,
                'last_page' => $lastPage,
                'per_page' => $limit,
            ]
        ], 200 , "success");

    }

    public function getById(Request $request , int $id){
        $city = $this->model->getCity($id);
        if(!$city){
            return Response::json(null, 404 , "city not found");
        }
        $field = $request->query()['fields'] ?? null;
        $city = $this->fieldFilter->filter([$city] , $field , $this->allowedFields);
        return Response::json($city, 200 , "success");
    }

    public function create(array $data){
       try{
           $cityId = $this->model->createCity($data['name'] , $data['province_id']);
           return Response::json(['id'=> $cityId], 201 , "city created successfully");
       }catch (PDOException $e){
           return  Response::json(null, 500 , "failed to create city");
       }
    }

    public function update(int $id , array $data){
        try{
            $cityId = $this->model->updateCity($id , $data['name']);
            if($cityId === false){
                return Response::json(null, 404 , "city not found");
            }
            return Response::json(['id'=>$cityId] , 200 , "city updated successfully");
        }catch(PDOException $e){
            return Response::json(null , 500 , "failed to update city");
        }
    }

    public function delete(int $id){
        try{
            $cityId = $this->model->deleteCity($id);
            if($cityId === false){
                return Response::json(null, 404 , "city not found");
            }
            return Response::json(['id'=>$cityId] , 200 , "city deleted successfully");

        }catch(PDOException $e){
            return Response::json(null, 500 , "failed to delete city");
        }

    }

}
