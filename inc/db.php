<?php

$db = new PDO('mysql:host=localhost;dbname=customer-info;charset=utf8', 'root', '12345');

if(!$db){
    echo 'Error in Database Connection';
}

?>