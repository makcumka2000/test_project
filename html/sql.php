<?php
// подключение к базе
$db_connect = pg_connect( " host=127.0.0.1 port=5432 dbname=test user=dxrist password=112233" ) ;
if ($db_connect==false){
    echo "ошибка соединения с бд";
}
else{
    //проверка на существование города в бд, есди есть, то вытаскиваем id
    $sql_q1 = "SELECT \"id_City\" FROM \"City_info\" WHERE \"City\" = '$_POST[city]'";
    $result_sql_q1 = pg_query( $db_connect , $sql_q1 );
    $a = pg_fetch_array($result_sql_q1);
    if(empty($a)){
        //добавление в бд если города нет
        $sql_q2 = "INSERT INTO \"City_info\" (\"City\") VALUES ('$_POST[city]');";
        $result_sql_q2= pg_query( $db_connect , $sql_q2);
        //вытаскиваем id который присвоили городу
        $sql_q3 = "SELECT \"id_City\" FROM \"City_info\" WHERE \"City\" = '$_POST[city]'";
        $result_sql_q3 = pg_query( $db_connect , $sql_q3);
        $b = pg_fetch_array($result_sql_q3);
        //вставка данных в таблицу из формы
        $sql_q4 = "INSERT INTO \"User_info\" (\"Nick_name\",\"Full_name\", \"email\",\"Birthdate\", \"City\")
        VALUES ( '$_POST[nick]' , '$_POST[name]' , '$_POST[email]' , '$_POST[data]' , '$b[id_City]'); " ;
        $result_sql_q4 = pg_query( $db_connect , $sql_q4 );
    }else {
    $sql_q2 = "INSERT INTO \"User_info\" (\"Nick_name\",\"Full_name\", \"email\",\"Birthdate\", \"City\")
    VALUES ( '$_POST[nick]' , '$_POST[name]' , '$_POST[email]' , '$_POST[data]' , '$a[id_City]'); " ;
    $insert = pg_query( $db_connect , $sql_q2 );
    pg_close($db_connect);
    }
}