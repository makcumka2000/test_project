<?php
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
    echo $e -> getMessage();
}

function _pgSelect ($s_Column, $table, $w_Columns, $condition, $pdo) {
    $sql = "SELECT $s_Column FROM $table WHERE $w_Columns LIKE '$condition' ;";
    $prep = $pdo -> prepare($sql) ;
    $prep -> execute();
    try {
        $prep -> execute();
    } catch (Exception $e){
        echo $e-> getMessage("Ошибка заполнения формы");
    }
    $fetch =  $prep-> fetch (PDO::FETCH_ASSOC);
    return $fetch;
}


$querry = _pgSelect('id','cities', 'city', $_POST['city'],$dbc);

/* 
    //проверка на существование города в бд, есди есть, то вытаскиваем id
    $sql = "SELECT \"id\" FROM \"cities\" WHERE \"city\" = \"'$_POST[city]'\"";
    $result = pg_query( $pgsql_connect , $sql );
    $result_fetch = pg_fetch_array($result);
    if(empty($result_fetch)){
        //добавление в бд если города нет
        $sql_q2 = "INSERT INTO \"cities\" (\"city\") VALUES ('$_POST[city]');";
        $result_sql_q2= pg_query( $pgsql_connect , $sql_q2);
        //вытаскиваем id который присвоили городу
        $sql_q3 = "SELECT \"id_City\" FROM \"City_info\" WHERE \"City\" = '$_POST[city]'";
        $result_sql_q3 = pg_query( $pgsql_connect , $sql_q3);
        $b = pg_fetch_array($result_sql_q3);
    }
    $sql_q4 = "INSERT INTO \"User_info\" (\"Nick_name\",\"Full_name\", \"email\",\"Birthdate\", \"City\")
        VALUES ( '$_POST[nick]' , '$_POST[name]' , '$_POST[email]' , '$_POST[data]' , '$b[id_City]'); " ;
        $result_sql_q4 = pg_query( $pgsql_connect , $sql_q4 );
        pg_close($pgsql_connect); */