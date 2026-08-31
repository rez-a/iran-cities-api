<?php
namespace Iran\Controllers\V2;


use Iran\Core\Response;
use Iran\Models\UsersModel;
use Iran\Services\JwtService;
use Iran\Core\Request;
use Throwable;

class AuthController{

    private UsersModel $usersModel;
    private JwtService $jwt;
    private Request $req;

    public function __construct(UsersModel $usersModel , JwtService $jwtService , Request $req){
        $this->usersModel = $usersModel;
        $this->jwt = $jwtService;
        $this->req = $req;
    }

    public function login(array $data){

        $user = $this->usersModel->findByUsername($data['username']);

        if(!$user){
            return  Response::json(null , 401 , 'invalid credentials');
        }

        if(!password_verify($data['password'], $user['password'])){
            return  Response::json(null , 401 , 'invalid credentials');
        }

        $now = time();
        $payload = [
            "iat" => $now,
            "sub" => $user['id'],
            "name" => $user['name'],
            "role" => $user['role'],
            "exp"=> $now + 3600
        ];
        $token = $this->jwt->generate($payload);

       return Response::json([
            "token" => $token,
        ] , 200,'login successful');
    }

    public function test_auth(){

        $token = $this->req->bearerToken();
        if(!$token){
            return Response::json(null , 401 , 'token required');
        }
        try{
            $payload = $this->jwt->validate($token);
            return Response::json(['user' => $payload] , 200,'token valid');
        }catch (Throwable $exception){
            return Response::json(null , 401 , 'token invalid');
        }
    }
}
