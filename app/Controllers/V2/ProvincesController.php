<?php
namespace Iran\Controllers\V2;


use Iran\Core\Request;
use Iran\Core\Response;
use Iran\Models\ProvincesModel;
use Iran\Services\CacheService;
use Iran\Services\FieldFilter;
use Iran\Services\Ordering;
use PDOException;

class ProvincesController{
    private ProvincesModel $model;
    private FieldFilter $fieldFilter;
    private Ordering $ordering;
    private CacheService $cacheService;
    private array $allowedFields = ['id' , 'name' ];
    private array $allowedSortFields = ['id' , 'name' ];
    private array $defaultSort = ['field'=>'id' , 'order'=>'ASC'];
    private string $cachePrefix = 'provinces:v2:';
    public function __construct(ProvincesModel $model , FieldFilter $fieldFilter , Ordering $ordering , CacheService $cacheService){
        $this->model = $model;
        $this->fieldFilter = $fieldFilter;
        $this->ordering = $ordering;
        $this->cacheService = $cacheService;


    }

    public function index( Request $request,int $page = 1, int $limit = 10)
    {

        $query = $request->query();
        $cacheKey = $this->cachePrefix.http_build_query($query);
        $cached = $this->cacheService->get($cacheKey);
        if($cached !==null){
            return Response::json($cached , 200 , 'success');
        }

        $fields = $request->query()['fields'] ?? null;
        $sortField = $request->query()['sort'] ?? null;
        $sort = $this->ordering->parse($sortField , $this->allowedSortFields , $this->defaultSort);
        $offset = ($page - 1) * $limit;
        $provinces = $this->model->getPaginated($limit, $offset,$sort);
        $totalProvinces = $this->model->getTotal();
        $lastPage = (int) ceil($totalProvinces / $limit);

        $provinces = $this->fieldFilter->filter($provinces, $fields , $this->allowedFields);
        $response = [
            'items'=>$provinces,
            'pagination' => [
                'total' => $totalProvinces,
                'current_page' => $page,
                'last_page' => $lastPage,
                'per_page' => $limit,
            ]
        ];
        $this->cacheService->set($cacheKey, $response, 3600);
        return Response::json($response, 200 , "success");
    }
    public function getById(Request $request , int $id){
        $query = $request->query();
        $cacheKey = $this->cachePrefix.$id.http_build_query($query);
        $cached = $this->cacheService->get($cacheKey);
        if($cached !==null){
            return Response::json($cached , 200 , 'success');
        }

        $province = $this->model->getProvinces($id);
        if(!$province){
            return Response::json(null, 404 , "provinces not found");
        }
        $field = $request->query()['fields'] ?? null;
        $province = $this->fieldFilter->filter([$province] , $field , $this->allowedFields);

        $this->cacheService->set($cacheKey , $province , 3600);
        return Response::json($province , 200 , "success");
    }

    public function create(array $data){
        try{
            $provinceId = $this->model->createProvinces($data['name']);
            $this->cacheService->clearByPrefix($this->cachePrefix);
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
            $this->cacheService->clearByPrefix($this->cachePrefix);
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
            $this->cacheService->clearByPrefix($this->cachePrefix);
            return Response::json(['id'=>$provinceId] , 200 , "province deleted successfully");
        }catch (PDOException $e){
            return Response::json(null, 500 , "failed to delete province");
        }

    }
}
