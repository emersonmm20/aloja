<?php
include '../config/conexion.php';
$conn = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numero = $_POST['numero'];
    $capacidad = $_POST['capacidad'];
    $estado = $_POST['estado'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    $imagen = "";
    if (!empty($_FILES["imagen"]["name"])) {
        $imagen = basename($_FILES["imagen"]["name"]);
        $rutaDestino = "../recursos/habitaciones/" . $imagen;
        move_uploaded_file($_FILES["imagen"]["tmp_name"], $rutaDestino);
    }

    $query = "INSERT INTO habitaciones (NUMERO, CAPACIDAD, ESTADO, DESCRIPCION, PRECIO, IMAGEN)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("iissds", $numero, $capacidad, $estado, $descripcion, $precio, $imagen);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al crear habitación: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Habitación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Crear Nueva Habitación</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="numero" class="form-label">Número de Habitación</label>
            <input type="number" class="form-control" name="numero" required>
        </div>
        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" class="form-control" name="capacidad" required>
        </div>
        <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-control" name="estado" required>
                <option value="OCUPADA">Ocupada</option>
                <option value="DESOCUPADA">Desocupada</option>
                <option value="FUERA_DE_SERVICIO">Fuera de servicio</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" name="descripcion" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="precio" class="form-label">Precio (COP)</label>
            <input type="number" class="form-control" name="precio" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen</label>
            <input type="file" class="form-control" name="imagen">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="../index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>
