<?php
include '../conexion.php';
$id = $_POST['id'];
$query = "DELETE FROM tarifa WHERE idTARIFA='$id'";
mysqli_query($conn, $query);
header("Location: index.php");
?>
