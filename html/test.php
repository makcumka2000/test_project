<?php

$name = '++Dima';

$newName = preg_replace('/+/','',$name,-1);

echo $newName;