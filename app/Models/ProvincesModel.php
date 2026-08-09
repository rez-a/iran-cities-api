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
}
