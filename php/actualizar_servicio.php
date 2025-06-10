<?php
include "../config/conexion.php";
$conn = conectarDB();

$id = $_POST['idSERVICIOS'];
$desc = $_POST['DESCRIPCION'];
$estado = $_POST['ESTADO'];

$imagen = '';
if ($_FILES['IMAGEN']['name']) {
    $imagen = basename($_FILES['IMAGEN']['name']);
    $rutaDestino = "recursos/img/" . $imagen;
    move_uploaded_file($_FILES['IMAGEN']['tmp_name'], $rutaDestino);

    $query = "UPDATE servicios SET DESCRIPCION='$desc', ESTADO='$estado', IMAGEN='$imagen' WHERE idSERVICIOS='$id'";
} else {
    $query = "UPDATE servicios SET DESCRIPCION='$desc', ESTADO='$estado' WHERE idSERVICIOS='$id'";
}

if (mysqli_query($conn, $query)) {
    header("Location:../index.php");
} else {
    echo "Error al actualizar.";
}
?>
