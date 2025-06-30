<?php
include '../config/conexion.php'; 
$conn = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $descripcion = $_POST["descripcion"];
    $detalle = $_POST["detalle"];
    $estado = $_POST["estado"];

    // Guardar imagen
    $imagen = "";
    if (!empty($_FILES["imagen"]["name"])) {
        $imagen = basename($_FILES["imagen"]["name"]);
        $rutaDestino = "../recursos/promociones/" . $imagen;
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino);
    }

    $query = "INSERT INTO servicios (NOMBRE, DESCRIPCION, DETALLE, ESTADO, IMAGEN)
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $nombre, $descripcion, $detalle, $estado, $imagen);
    
    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al guardar el servicio.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Servicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Nuevo Servicio</h2>
    <form action="crear_servicio.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nombre del servicio:</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Detalle para el modal:</label>
            <textarea name="detalle" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <select name="estado" class="form-select">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Imagen:</label>
            <input type="file" name="imagen" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar Servicio</button>
        <a href="../index.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>
