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

        $city = $this->getCity($id);
        if(!$city){ return false; }

        $sql = "UPDATE city SET name = :name WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'id' => $id,
            'name' => $name
        ]);

        return $id;
    }

    public function deleteCity(int $id){
        $city = $this->getCity($id);
        if(!$city){ return false; }

        $sql = "DELETE FROM city WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([
            'id' => $id,
        ]);

        return $id;
    }

    public function getPaginated(int $limit , int $offset , array $sort)
    {
        $sql = "SELECT * FROM city 
                ORDER BY {$sort['field']} {$sort['order']}
                LIMIT :limit OFFSET :offset ";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotal()
    {
        $sql = 'SELECT COUNT(*) FROM city';
        $statement = $this->connection->query($sql);
        return (int) $statement->fetchColumn();
    }
}
