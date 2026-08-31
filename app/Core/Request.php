<?php
namespace Iran\Core;

class Request{
    private ?object $user = null;
    public function method(){
        return $_SERVER["REQUEST_METHOD"];
    }
    public function path(){
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public function query():array{
        return $_GET;
    }
    public function body(){
        $content = file_get_contents("php://input");
        return json_decode($content, true) ?? [];
    }

    public function bearerToken(){

        $header = getallheaders();
        $authorization = $header["Authorization"] ?? null;



        if(!$authorization){ return null;};
        if(!str_starts_with($authorization, 'Bearer ')){
            return null;
        }
        return substr($authorization, 7);
    }

    public function setUser( object $user) : void
    {
        $this->user = $user;

    }
    public function user() : object{
        return $this->user;
    }
}
