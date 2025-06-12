<?php
include '../conexion.php';

$tipo = $_POST['TIPOHABITACIONES'];
$capacidad = $_POST['CAPACIDAD'];
$precio = $_POST['PRECIOPORNOCHE'];
$descripcion = $_POST['DESCRIPCION'];

$query = "INSERT INTO tarifa (TIPOHABITACIONES, CAPACIDAD, PRECIOPORNOCHE, DESCRIPCION) 
          VALUES ('$tipo', '$capacidad', '$precio', '$descripcion')";

mysqli_query($conn, $query);
header("Location: index.php");
?>

