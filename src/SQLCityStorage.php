<?php

interface CityStorageInteface
{
    public function insert(): int;
    public function issetCity(): bool;
}

/**
 * from $_POST
 *
 * @param city_id
 * @param PDO $pdo connect
 *
 * @return id of last operation 
 **/

class SQLCityStorage implements CityStorageInteface
{
    public string $city;
    public PDO $pdo;

    function __construct(
        string $city,
        PDO $pdo
    ) {

        $this->city = $city;
        $this->pdo = $pdo;
    }

    public function select():int
    {
        $sql = "SELECT id FROM cities WHERE city = ?";
        $prep = $this->pdo->prepare($sql);
        $prep->bindParam(1, $this->city, PDO::PARAM_STR);
        $prep->execute();
        $id = $prep->fetch(PDO::FETCH_ASSOC);
        return $id['id'];
    } 
    
    public function insert(): int
    {
        $sql = "INSERT INTO cities VALUES (?)";
        $prep = $this->pdo ->prepare($sql);
        $prep->bindParam(1, $this->city, PDO::PARAM_STR);
        $prep->execute();
        $id = $this->pdo->lastInsertId();
        return $id;
    }

    public function issetCity(): bool
    {
        $sql = "SELECT id FROM cities WHERE city = ?";
        $prep = $this->pdo->prepare($sql);
        $prep->bindParam(1, $this->city, PDO::PARAM_STR);
        $prep->execute();
        $id = $prep->fetch(PDO::FETCH_ASSOC);
        if (isset($id['id'])) {
            return true;
        }
        return false;
    }

}
