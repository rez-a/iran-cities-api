<?php
namespace Iran\Core;


use ReflectionException;

class Router{

    private array $routes = [];
    private Container $container;

    public function __construct(Container $container){
        $this->container = $container;
    }

    private function matchRoute(string $requestPath , string $routePath): array|false
{
    $requestParts = explode("/" , trim($requestPath , "/"));
    $routeParts = explode("/" , trim($routePath , "/"));
    if(count($requestParts) !== count($routeParts)){ return false; }
    $parameters = [];
    foreach ($routeParts as $key => $part){
        if(str_starts_with($part , "{") && str_ends_with($part , "}")){
            $partName = trim($part , "{}");
            $parameters[$partName] = $requestParts[$key];
            continue;
        }
        if($part !== $requestParts[$key]){ return false; }
    }
    return $parameters;
}

    /**
     * @throws ReflectionException
     */
    public function dispatch(Request $request){

        foreach ($this->routes as $route){
            if($request->method() !== $route["method"]){ continue; }
            $parameters = $this->matchRoute($request->path(), $route["path"]);
            if($parameters === false){ continue; }

            [$controller , $method] = $route["handler"];
            $controller = $this->container->make($controller);

            return call_user_func([$controller , $method] , ...array_values($parameters));

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
