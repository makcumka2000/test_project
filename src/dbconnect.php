<?php 

$host = '127.0.0.1';
$port = '5432';
$db_name = 'test';
$user = 'dxrist';
$pass = '112233';
$dsn = "pgsql: host=$host; port=$port; dbname=$db_name";
$pdo_option = [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION];

// подключение к базе

$dbc = new PDO($dsn, $user, $pass, $pdo_option);