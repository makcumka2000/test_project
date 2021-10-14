<?php

/** 
 * from $_POST
 *
 * @param name 
 * @param nick
 * @param email
 * @param date
 * @param city_id
 *
 * @return id of last operation 
 **/

interface UserStorageInteface
{
    public function insert();
}

class SQLUserStorage implements UserStorageInteface
{

    public string $name;
    public string $nick;
    public int $city_id;
    public string $date;
    public string $email;
    public PDO $pdo;

    function __construct(
        string $name,
        string $nick,
        int $city_id,
        string $date,
        string $email,
        PDO $pdo
    ) {
        $this->name = $name;
        $this->nick = $nick;
        $this->city_id = $city_id;
        $this->date = $date;
        $this->email = $email;
        $this->pdo = $pdo;
    }

    public function insert(): int {
        $sql = "INSERT INTO users(full_name, nick_name, email, birthdate, city_id)
         VALUES (?, ?, ?, ?, ?)";
        $prep = $this->pdo->prepare($sql);
        $prep->bindParam(1, $this->name, PDO::PARAM_STR);
        $prep->bindParam(2, $this->nick, PDO::PARAM_STR);
        $prep->bindParam(3, $this->email, PDO::PARAM_STR);
        $prep->bindParam(4, $this->date, PDO::PARAM_STR);
        $prep->bindParam(5, $this->city_id, PDO::PARAM_STR);
        $prep->execute();
        return $this->pdo->lastInsertId();
    }
}
