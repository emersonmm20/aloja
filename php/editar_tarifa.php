<?php
include '../conexion.php';
$id = $_POST['id'];
$tipo = $_POST['TIPOHABITACIONES'];
$capacidad = $_POST['CAPACIDAD'];
$precio = $_POST['PRECIOPORNOCHE'];
$descripcion = $_POST['DESCRIPCION'];

$query = "UPDATE tarifa SET TIPOHABITACIONES='$tipo', CAPACIDAD='$capacidad', PRECIOPORNOCHE='$precio', DESCRIPCION='$descripcion' WHERE idTARIFA='$id'";
mysqli_query($conn, $query);
header("Location: index.php");
?>
