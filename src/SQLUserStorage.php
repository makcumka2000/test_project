<?php

require_once __DIR__ . "/interface.php";

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

class SQLUserStorage implements UserStorageInteface
{

    public string $name;
    public string $nick;
    public int $city_id;
    public string $date;
    public string $email;
    public PDO $pdo;

    function __construct(
        PDO $pdo
    ) {
        $this->pdo = $pdo;
    }

    public function insert(
        string $name,
        string $nick,
        int $city_id,
        string $date,
        string $email
    ): int {
        $sql = "INSERT INTO users(full_name, nick_name, email, birthdate, city_id)
         VALUES (?, ?, ?, ?, ?)";
        $prep = $this->pdo->prepare($sql);
        $prep->bindParam(1, $name, PDO::PARAM_STR);
        $prep->bindParam(2, $nick, PDO::PARAM_STR);
        $prep->bindParam(3, $email, PDO::PARAM_STR);
        $prep->bindParam(4, $date, PDO::PARAM_STR);
        $prep->bindParam(5, $city_id, PDO::PARAM_STR);
        $prep->execute();
        return $this->pdo->lastInsertId();
    }
}
