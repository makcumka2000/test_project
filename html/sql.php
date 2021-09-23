<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

$host ='127.0.0.1' ;
$port = '5432' ;
$db_name = 'test';
$user = 'dxrist' ;
$pass = '112233' ;
$dsn = "pgsql: host=$host; port=$port; dbname=$db_name"; 
$pdo_option = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

// подключение к базе
try {
    $dbc = new PDO ($dsn, $user, $pass, $pdo_option );
} catch (Exception $e){
    echo $e -> getMessage ();
    die;
}  

//функция Select
function _pgSelect (string $s_Column, string $i_Table, string $w_Column, $l_Condition, mixed $pdo) {
    $sql = "SELECT $s_Column FROM $i_Table WHERE $w_Column = ? ";
    try {
        $prep = $pdo -> prepare ($sql) ;
        $prep -> bindParam (1, $l_Condition, PDO::PARAM_STR);
        $prep -> execute ();
    } catch (Exception $e) {
        echo $e-> getMessage ();
        die;
    } 
    $fetch =  $prep-> fetch (PDO::FETCH_ASSOC);
    return (array) $fetch;
}

//функция InsertUser
function _pgInsertUser ( mixed $city_id,mixed $pdo){
    $sql = "INSERT INTO users(full_name, nick_name, email, birthdate, city_id) VALUES (?, ?, ?, ?, ?)";
    try {
        $prep = $pdo -> prepare ($sql);
        $prep -> bindParam (1,$_POST['name'] , PDO::PARAM_STR);
        $prep -> bindParam (2,$_POST['nick'] , PDO::PARAM_STR);
        $prep -> bindParam (3,$_POST['email'] , PDO::PARAM_STR);
        $prep -> bindParam (4,$_POST['data'] , PDO::PARAM_STR);
        $prep -> bindParam (5,$city_id , PDO::PARAM_STR);
        $prep -> execute ();
    } catch (Exception $e){
        echo $e-> getMessage ();
        die;
    }
}

//функция InsertCity
function _pgInsertCity (mixed $pdo){
    $sql = "INSERT INTO cities(city) VALUES (?)";
    try {
        $prep = $pdo -> prepare ($sql);
        $prep -> bindParam (1,$_POST['city'] , PDO::PARAM_STR);
        $prep -> execute ();
    } catch (Exception $e){
        echo $e-> getMessage ();
        die;
    }
}

//функция проверки данных
function _issetValue ($querry) {
    if (isset($querry['id'])){
        echo "Пользователь с такими данными уже существует";
        die;
    }elseif(!isset($querry[0])){
        echo "Вы ввели не все данные";
        die;
    }
}

if (isset($_POST)){
    $querryCityId = _pgSelect ('id', 'cities', 'city', $_POST['city'], $dbc);
    if (isset($querryCityId[0])){
        $newCity = _pgInsertCity ($dbc);
        $querryCityId = _pgSelect ('id','cities', 'city', $_POST['city'],$dbc);
    }
    $querryEmail = _pgSelect ('id','users', 'email',$_POST['email'], $dbc);
    $email = _issetValue($querryEmail);
    $querryNick = _pgSelect ('id','users', 'nick_name',$_POST['nick'], $dbc);
    $nick = _issetValue($querryNick);
    $newUser = _pgInsertUser($querryCityId['id'],$dbc);
    echo "Регистрация прошла успешно";
} 
$dbc=null;
?>