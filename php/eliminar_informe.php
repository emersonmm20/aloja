<?php
include '../config/conexion.php';

$conexion = conectarDB();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM informes WHERE id = $id";

    if ($conexion->query($sql)) {
        header("Location: ../informes.php");
        exit();
    } else {
        echo "Error al eliminar el informe: " . $conexion->error;
    }
} else {
    echo "ID no especificado.";
}
?>