<?php
namespace Iran\Models;

use PDO;

class UsersModel{
    private PDO $connection;

    public function __construct(PDO $connection){
        $this->connection = $connection;
    }


    public function findByUsername(string $username){
        $sql = "SELECT * FROM users WHERE username = :username";
        $statment = $this->connection->prepare($sql);
        $statment->bindValue(":username", $username);
        $statment->execute();

        return $statment->fetch(PDO::FETCH_ASSOC);
    }
}
