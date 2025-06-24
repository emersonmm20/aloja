<?php
include '../config/conexion.php';

$conn = conectarDB();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "DELETE FROM tarifas WHERE idTARIFAS = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error al eliminar la tarifa: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID no válido.";
} ?>
