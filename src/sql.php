<?php
ini_set('display_errors', 1);

ini_set('display_startup_errors', 1);

error_reporting(E_ALL);

require __DIR__."/dbconnect.php";
require __DIR__."/SQLUserStorage.php";
require __DIR__."/SQLCityStorage.php";

function validateData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }

if (isset($_POST)) {
    $name = validateData($_POST['name']);
    $nick = validateData($_POST['nick']);
    $city = validateData($_POST['city']);
    $date = validateData($_POST['data']);
    $email = validateData($_POST['email']);
    $header = 'http://testproject.local/';

    
    $newCity = new SQLCityStorage($city, $dbc);
    $newCity->issetCity();
    if ($newCity==false) {
        $cityID = $newCity->insert();
    }
    $cityID=$newCity->select();
    $newUser = new SQLUserStorage($name, $nick, $cityID, $date, $email, $dbc);
    $newUser->insert();
    header("Refresh: 5, url=$header");
    echo "Регистрация прошла успешно";
}
