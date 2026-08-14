<?php
namespace Iran\Core;


use Exception;
use ReflectionException;
use Iran\Core\Response;
use ReflectionMethod;

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
     * @throws Exception
     */
    private function resolveArguments(object $controller , string $method , array $routeParameters , Request $request): array
    {
        $reflection = new ReflectionMethod($controller , $method);
        $query = $request->query();
        $arguments = [];
        foreach($reflection->getParameters() as $parameter){
            $parameterName = $parameter->getName();

            if(key_exists($parameterName , $routeParameters)){
                $arguments[] = $routeParameters[$parameterName];
                continue;
            }
            if(key_exists($parameterName , $query)){
                $arguments[] = $query[$parameterName];
                continue;
            }
            if($parameterName === 'data'){
                $arguments[] = $request->body();
                continue;
            }
            if($parameter->isDefaultValueAvailable()){
                $arguments[] = $parameter->getDefaultValue();
                continue;
            }

            throw new Exception("cannot resolve parameter : {$parameterName}");
        }
        return $arguments;
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

            $arguments = $this->resolveArguments($controller , $method , $parameters , $request);

            return call_user_func([$controller , $method] , ...array_values($arguments));

        }
            return Response::json(null, 404 , "route not found");
    }

    public function addRoute($method , $path , $handler){
        $this->routes[] = [
            "method" => $method,
            "path" => $path,
            "handler" => $handler
        ];
    }


}
