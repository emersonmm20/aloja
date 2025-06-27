<?php
include '../config/conexion.php';
$conn = conectarDB();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Asegúrate de que estos name coincidan con el formulario HTML
    $habitacion_id = $_POST['numeroHabitaciones'];
    $capacidad = $_POST['capacidad'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $sql = "INSERT INTO tarifas (idHABITACIONES, CAPACIDAD, PRECIOPORNOCHE, DESCRIPCION) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("iids", $habitacion_id, $capacidad, $precio, $descripcion);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al guardar la tarifa: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Acceso no permitido.";
}
?>
