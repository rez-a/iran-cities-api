<?php
namespace Iran\Models;


use PDO;

class ProvincesModel{

    private PDO $connection;

    public function __construct(PDO $connection){
        $this->connection = $connection;
    }
    public function getAll(){
        $sql = "SELECT * FROM province";
        $statement = $this->connection->query($sql);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getProvinces($id){
        $sql = "SELECT * FROM province WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([':id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
