<?php

namespace Iran\Models;

use PDO;

class CitiesModel{
    private PDO $connection;
    public function __construct(PDO $connection){
        $this->connection = $connection;
    }

    public function getAll(){
        $sql = "SELECT * from city";
        $statement = $this->connection->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCity($id){
        $sql = "SELECT * from city where id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
