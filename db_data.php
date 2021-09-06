<?php
$data = date("Y-m-d",strtotime($_POST['data']));
$db_connect = pg_connect( " host=127.0.0.1 port=5432 dbname=test user=dxrist password=112233" ) ;
if ($db_connect==false){
    echo "ошибка соединения с бд";
}
$sql = "INSERT INTO registration ( nickname, Full_name, email, date, city )
VALUES ( '$_POST[nick]','$_POST[name]','$_POST[email]','$data','$_POST[city]') ; " ;
$insert = pg_query( $db_connect , $sql );
pg_close ( $db_connect); 
