<?php
include "../config/conexion.php";
$conn = conectarDB();
$id = $_GET['id'];

$query = "DELETE FROM servicios WHERE idSERVICIOS='$id'";
if (mysqli_query($conn, $query)) {
    header("Location: ../index.php");
} else {
    echo "Error al eliminar.";
}
?>