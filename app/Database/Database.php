<?php
namespace Iran\Database;

use PDO;
use Dotenv\Dotenv;

class Database{
    private PDO $connection;

    public function __construct(){

        $dotenv = Dotenv::createImmutable(dirname(__DIR__ , 2));
        $dotenv->load();

        $this->connection = new PDO("mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_DATABASE']};charset=utf8mb4" , $_ENV['DB_USERNAME'] , $_ENV['DB_PASSWORD']);
    }

    public function getConnection(){
        return $this->connection;
    }
}
