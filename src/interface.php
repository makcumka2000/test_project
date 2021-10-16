<?php

interface CityStorageInteface
{
    public function insert(string $city): int;
    public function issetCity(string $city): bool;
    public function select (string $city): int;
}

interface UserStorageInteface
{
    public function insert(
        string $name,
        string $nick,
        int $city_id,
        string $date,
        string $email
    );
}