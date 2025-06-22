<?php 
function conectarDB(){

    $host= "localhost";
    $user= "root";
    $password="12345678";
    $database="mydb";

    $mysqli = new mysqli($host, $user, $password, $database);
    if ($mysqli->connect_errno) {
        echo "Fallo al conectar a MySQL: (" . $mysqli->connect_error . ") " . $mysqli->connect_error;
    }
    else{
        // echo "conexion exitosa";
    }
    return $mysqli;
}

?>