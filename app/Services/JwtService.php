<?php
namespace Iran\Services;


use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Dotenv\Dotenv;

class JwtService{
    private string $key;

    public function __construct(){
        $dotenv = Dotenv::createImmutable(dirname(__DIR__ , 2));
        $dotenv->load();
        $this->key = $_ENV['JWT_KEY'];
    }

    public function generate(array $payload=[]): string{
        return JWT::encode($payload, $this->key , 'HS256');
    }

    public function validate(string $token){
        return JWT::decode($token, new Key($this->key, 'HS256'));
    }
}
