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
} catch (PDOException $e){
    echo $e -> getMessage ();
    die;
}  

//функция Select
function _pgSelect ( string $s_Column, string $table, string $w_Columns, mixed $condition, mixed $pdo) {
    $sql = "SELECT $s_Column FROM $table WHERE $w_Columns LIKE '$condition' ;";
    $prep = $pdo -> prepare ($sql) ;
    try {
        $prep -> execute ();
    } catch (Exception $e){
        echo $e-> getMessage ();
        die;
    } 
    $fetch =  $prep-> fetch (PDO::FETCH_NAMED);
    return (array) $fetch;
}

//функция INSERT
function _pgInsert (string $table, mixed $values, mixed $pdo){
    $sql = "INSERT INTO $table VALUES ('$values')";
    $prep = $pdo -> prepare ($sql);
    try {
        $prep -> execute ();
    } catch (Exception $e){
        echo $e-> getMessage ();
        die;
    }
}

if (isset($_POST)){
    $querryCityId = _pgSelect ('id','cities', 'city', $_POST['city'],$dbc);
    if (isset($querryCityId[0])){
        $cityTable = "cities(city)";
        $cityValues = $_POST['city'];
        $newCity = _pgInsert ($cityTable, $cityValues, $dbc);
        $querryCityId = _pgSelect ('id','cities', 'city', $_POST['city'],$dbc);
    }
    $querryEmail = _pgSelect ('email','users', 'email',$_POST['email'], $dbc);
    
    if (!isset($querryEmail[0])){
        echo "Пользователь с таким email уже зарегистрирован";
        die;
    }
    $userTable = "users(full_name, nick_name, email, birthdate, city_id)";
    $userValues = "$_POST[name]','$_POST[nick]','$_POST[email]','$_POST[data]','$querryCityId[id]";
    try {
        $newUser = _pgInsert($userTable, $userValues, $dbc);
    }catch (Exception $e){
        echo $e-> getMessage ();
    }
    echo "Регистрация прошла успешно";
}
$dbc=null;
?>