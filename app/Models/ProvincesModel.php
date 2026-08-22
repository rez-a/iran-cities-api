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
    public function getProvinces(int $id){
        $sql = "SELECT * FROM province WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([':id' => $id]);
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public  function createProvinces(string $name)
    {
        $sql = "INSERT INTO province (name) VALUES (:name)";
        $statement = $this->connection->prepare($sql);
        $statement->execute([':name' => $name]);
        return $this->connection->lastInsertId();
    }

    public function updateProvinces( int $id , string $name){
        $province = $this->getProvinces($id);
        if(!$province){
            return false;
        }
        $sql = "UPDATE province SET name = :name WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([':name' => $name, ':id' => $id]);
        return $id;
    }

    public function deleteProvinces( int $id){
        $province = $this->getProvinces($id);
        if(!$province){
            return false;
        }
        $sql = "DELETE FROM province WHERE id = :id";
        $statement = $this->connection->prepare($sql);
        $statement->execute([':id' => $id]);
        return $id;
    }

    public function getPaginated(int $limit , int $offset, array $sort)
    {
        $sql = "SELECT * FROM province
                ORDER BY {$sort['field']} {$sort['order']}
                LIMIT :limit OFFSET :offset";
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotal()
    {
        $sql = 'SELECT COUNT(*) FROM province';
        $statement = $this->connection->query($sql);
        return (int) $statement->fetchColumn();
    }
}
