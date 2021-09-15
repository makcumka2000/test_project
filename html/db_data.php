<?php
$db_connect = pg_connect( " host=127.0.0.1 port=5432 dbname=test user=dxrist password=112233" ) ;
if ($db_connect==false){
    echo "ошибка соединения с бд";
}
else{
    $sql = "INSERT INTO \"User_info\" (\"Nick_name\",\"Full_name\", \"email\",\"Birthdate\", \"City\")
    VALUES ( '$_POST[nick]' , '$_POST[name]' , '$_POST[email]' , '$_POST[data]' , '$_POST[city]'); " ;
    $insert = pg_query( $db_connect , $sql );
    var_dump($insert);
}
