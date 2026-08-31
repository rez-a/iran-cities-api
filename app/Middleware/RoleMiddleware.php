<?php

namespace Iran\Middleware;

use Iran\Core\Request;
use Iran\Core\Response;

class RoleMiddleware{
    public function handle(Request $request, string $requiredRole){
        $user = $request->user();
        if(!$user){
            return Response::json(null , 401 , "unauthorized");
        }
        if($user->role !== $requiredRole){
            return Response::json(null , 403 , "forbidden");
        }
        return true;
    }
}
