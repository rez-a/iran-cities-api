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
}
