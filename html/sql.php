<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

$host = '127.0.0.1';
$port = '5432';
$db_name = 'test';
$user = 'dxrist';
$pass = '112233';
$dsn = "pgsql: host=$host; port=$port; dbname=$db_name";
$pdo_option = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

// подключение к базе

$dbc = new PDO($dsn, $user, $pass, $pdo_option);

//функция Select

interface ValidateParams
{
    function _validateValue($querry);
}

class SQLUsers implements ValidateParams
{

    public $name, $nick, $city, $date, $email;

    function __construct($name, $nick, $city, $date, $email)
    {
        $this->name = $name;
        $this->nick = $nick;
        $this->city = $city;
        $this->$date = $date;
        $this->email = $email;
    }

    //функция Select
    function _select(string $field, string $table, array $Condition, PDO $pdo): array
    {
        foreach ($Condition as $key => $value) {
            $sql = "SELECT $field FROM $table WHERE $key = ? ";
            $prep = $pdo->prepare($sql);
            $prep->bindParam(1, $value, PDO::PARAM_STR);
            $prep->execute();
        }
        $fetch =  $prep->fetch(PDO::FETCH_ASSOC);
        $prep = null;
        return (array) $fetch;
    }

    //функция InsertUser
    function _insertUser(
        string $name,
        string $nick,
        string $email,
        string $date,
        int $city_id,
        PDO $pdo
    ) {
        $sql = "INSERT INTO users(full_name, nick_name, email, birthdate, city_id) VALUES (?, ?, ?, ?, ?)";
        $prep = $pdo->prepare($sql);
        $prep->bindParam(1, $name, PDO::PARAM_STR);
        $prep->bindParam(2, $nick, PDO::PARAM_STR);
        $prep->bindParam(3, $email, PDO::PARAM_STR);
        $prep->bindParam(4, $date, PDO::PARAM_STR);
        $prep->bindParam(5, $city_id, PDO::PARAM_STR);
        $prep->execute();
    }

    //функция InsertCity
    function _insertCity(string $city, PDO $pdo)
    {
        $sql = "INSERT INTO cities VALUES (?)";
        $prep = $pdo->prepare($sql);
        $prep->bindParam(1, $city, PDO::PARAM_STR);
        $prep->execute();
    }

    function _validateValue($querry)
    {
        if (isset($querry['id'])) {
            echo "Пользователь с такими данными уже существует";
            die;
        } elseif (!isset($querry[0])) {
            echo "Вы ввели не все данные";
            die;
        }
    }
}

if (isset($_POST)) {
    $name = $_POST['name'];
    $nick = $_POST['nick'];
    $city = $_POST['city'];
    $date = $_POST['data'];
    $email = $_POST['email'];

    $user = new SQLUsers($name, $nick, $city, $date, $email);
    $city_id = $user->_select('city', 'cities', ['city' => $city], $dbc);
    if (isset($city_id[0])){
        $user->_insertCity($city, $dbc);
        $city_id = $user->_select('city', 'cities', ['city' => $city], $dbc);
    }
    $user->_insertUser($name,$nick,$email,$date,$city_id['id'],$dbc);
}