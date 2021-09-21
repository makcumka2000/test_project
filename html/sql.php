<?php
ini_set('error_reporting',E_ALL);
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
function _pgSelect ($s_Column, $table, $w_Columns, $condition, $pdo) {
    $sql = "SELECT $s_Column FROM $table WHERE $w_Columns LIKE '$condition' ;";
    $prep = $pdo -> prepare ($sql) ;
    try {
        $prep -> execute ();
    } catch (Exception $e){
        echo $e-> getMessage ();
        die;
    } 
    $fetch =  $prep-> fetch (PDO::FETCH_ASSOC);
    return $fetch;
}

//функция INSERT
function _pgInsert ($table, $values, $pdo){
    $sql = "INSERT INTO $table VALUES ('$values')";
    $prep = $pdo -> prepare ($sql);
    try {
        $prep -> execute ();
    } catch (Exception $e){
        echo $e-> getMessage ();
        die;
    }
}

$querry = _pgSelect ('id','cities', 'city', $_POST['city'],$dbc);
if (empty ($querry)){
    $cityTable = "cities(city)";
    $cityValues = $_POST['city'];
    $newCity = _pgInsert ($cityTable, $cityValues, $dbc);
    $querry = _pgSelect ('id','cities', 'city', $_POST['city'],$dbc);
}
$userTable = "users(full_name, nick_name, email, birthdate, city_id)";
$userValues = "$_POST[name]','$_POST[nick]','$_POST[email]','$_POST[data]','$querry[id]";
try {
    $newUser = _pgInsert($userTable, $userValues, $dbc);
}catch (Exception $e){
    echo $e-> getMessage ();
}
$dbc=null;