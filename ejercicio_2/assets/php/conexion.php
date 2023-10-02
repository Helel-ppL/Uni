<?php

$host = "localhost";
$user = "root";
$pass = "";
$db   = "ejercicio2";

$conn = mysqli_connect($host, $user, $pass, $db);

if(!$conn){
    die(mysqli_error($conn));
}else{
    //echo "Conectado", "<br>";
}

?>