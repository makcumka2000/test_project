<?php

require_once __DIR__ . "/interface.php";

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
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }

    public function select(string $city):int
    {
        $sql = "SELECT id FROM cities WHERE city = ?";
        $prep = $this->pdo->prepare($sql);
        $prep->bindParam(1, $city, PDO::PARAM_STR);
        $prep->execute();
        $id = $prep->fetch(PDO::FETCH_ASSOC);
        return $id['id'];
    } 
    
    public function insert(string $city): int
    {
        $sql = "INSERT INTO cities VALUES (?)";
        $prep = $this->pdo ->prepare($sql);
        $prep->bindParam(1, $city, PDO::PARAM_STR);
        $prep->execute();
        $id = $this->pdo->lastInsertId();
        return $id;
    }

    public function issetCity(string $city): bool
    {
        $sql = "SELECT id FROM cities WHERE city = ?";
        $prep = $this->pdo->prepare($sql);
        $prep->bindParam(1, $city, PDO::PARAM_STR);
        $prep->execute();
        $id = $prep->fetch(PDO::FETCH_ASSOC);
        if (isset($id['id'])) {
            return true;
        }
        return false;
    }

}
