<?php

namespace Iran\Middleware;


use Iran\Services\JwtService;
use Iran\Core\Request;
use Iran\Core\Response;
use Throwable;

class AuthMiddleware
{
    private JwtService $jwt;

    public function __construct(JWTService $jwt){
        $this->jwt = $jwt;
    }

    public function handle(Request $request){
        $token = $request->bearerToken();

        if(!$token){
            return Response::json(null, 401 , "token required");
        }
        try{
           $payload =  $this->jwt->validate($token);
           $request->setUser($payload);
            return true;
        }catch(Throwable $e){
            return Response::json(null, 401 , "token invalid");
        }
    }
}
