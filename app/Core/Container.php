<?php

namespace Iran\Core;

use Exception;
use Iran\Database\Database;
use ReflectionClass;
use PDO;
use ReflectionException;

class Container{

    /**
     * @throws ReflectionException
     * @throws Exception
     */
    public function make(string $class)
    {
        if($class === PDO::class){
            $database = new Database();
            return $database->getConnection();
        }
        $reflection = new ReflectionClass($class);
        $constructor = $reflection->getConstructor();
        if(!$constructor){return new $class;}

        $dependencies = [];
        foreach($constructor->getParameters() as $param){
            $type = $param->getType();
            if(!$type){
                throw new Exception("Cannot Resolve {$param->getName()}");
            }

            $dependencies[] = $this->make($type->getName());
        }
        return  $reflection->newInstanceArgs($dependencies);

    }
}
