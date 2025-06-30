<?php
include '../config/conexion.php';
$conn = conectarDB();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $numero = (int) $_POST['numero'];
    $capacidad = (int) $_POST['capacidad'];
    $descripcion = trim($_POST['descripcion']);
    $precio = floatval(str_replace('.', '', $_POST['precio'])); // Asegura formato numérico
    $estado = $_POST['estado'];

    // Eliminado el manejo de imagen ya que no existe la columna
    
    // Actualizar base de datos (versión simplificada sin IMAGEN)
    $query = "UPDATE habitaciones SET NUMERO = ?, CAPACIDAD = ?, ESTADO = ?, DESCRIPCION = ?, PRECIO = ? WHERE idHABITACIONES = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iissdi", $numero, $capacidad, $estado, $descripcion, $precio, $id);

    // Ejecutar y verificar resultado
    if ($stmt->execute()) {
        header("Location: ../index.php?mensaje=actualizado");
        exit();
    } else {
        echo "❌ Error al actualizar la habitación: " . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>