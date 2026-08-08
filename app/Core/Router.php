<?php
namespace Iran\Core;


use ReflectionException;

class Router{

    private array $routes = [];
    private Container $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    /**
     * @throws ReflectionException
     */
    public function dispatch(Request $request){

        foreach ($this->routes as $route){
            if($request->method() === $route["method"] && $request->path() === $route["path"]){
                [$controller , $method] = $route["handler"];
                $controller = $this->container->make($controller);
                return call_user_func([$controller , $method]);
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
