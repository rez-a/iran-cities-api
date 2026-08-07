<?php
namespace Iran\Core;

class Router{

    private array $routes = [];

    public function dispatch($request){

        foreach ($this->routes as $route){
            if($request["method"] === $route["method"] && $request["path"] === $route["path"]){
                $controller = new $route["handler"][0];
                return call_user_func([$controller, $route["handler"][1]]);
            }
        }
            return "404 not found";
    }

    public function addRoute($method , $path , $handler){
        $this->routes[] = [
            "method" => $method,
            "path" => $path,
            "handler" => $handler
        ];
    }


}
