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

    public function getCity(int $id){
        $sql = "SELECT * from city where id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function createCity(string $name , int $province_id){
        $sql = "INSERT INTO city (name , province_id) VALUES (:name , :province_id)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'name' => $name,
            'province_id' => $province_id
        ]);

        return $this->connection->lastInsertId();
    }

    public function updateCity(int $id , string $name){
        $checkCitySql = "SELECT * from city WHERE id = :id";
        $checkStatement = $this->connection->prepare($checkCitySql);
        $checkStatement->execute(['id' => $id]);
        $city = $checkStatement->fetch(PDO::FETCH_ASSOC);

        if(!$city){
            return  false;
        }


        $sql = "UPDATE city SET name = :name WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'id' => $id,
            'name' => $name
        ]);

        return $id;
    }
}
