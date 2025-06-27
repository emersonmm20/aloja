<?php
include '../config/conexion.php';
$conn = conectarDB();

// Validar que el formulario venga con datos
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $documento = $_POST['documento_id'] ?? '';
    $rol = $_POST['rol'] ?? '';
    $estado = $_POST['estado'] ?? '';

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        $id = $_POST['id'];
        $stmt = $conn->prepare("UPDATE usuarios SET nombre=?, documento_id=?, rol=?, estado=? WHERE id=?");
        $stmt->bind_param("ssssi", $nombre, $documento, $rol, $estado, $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: ./editar_usuario.php?exito=editar");
        } else {
            echo "Error al editar: " . $conn->error;
        }
    } else {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, documento_id, rol, estado) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nombre, $documento, $rol, $estado);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            header("Location: ../index.php");
        } else {
            echo "Error al crear: " . $conn->error;
        }
    }

    exit;
} else {
    header("Location: index.php");
    exit;
}
?>