<?php

interface StorageFactoryInteface{

   public function createUserStorage(): UserStorageInterface;
   
   public function createCityStorage(): CityStorageInteface
}
