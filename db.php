<?php 
$host = 'localhost';
$user = 'root';
$db_name = 'photo_album';
$password = '';

$db_connect = new mysqli($host,$user,$password,$db_name);

if($db_connect->connect_error){
    echo "Mysqli Connect Error";
}