<?php
include '../config/conexion.php';

$conn = conectarDB();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitiza el valor recibido

    $sql = "DELETE FROM informes WHERE idINFORMES = $id";

    if ($conn->query($sql)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al eliminar el informe: " . $conn->error;
    }
} else {
    echo "ID no especificado.";
}
