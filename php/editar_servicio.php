<?php
include "../config/conexion.php";
$conn = conectarDB();
$id = $_GET['id'];

$query = "SELECT * FROM servicios WHERE idSERVICIOS = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$resultado = $stmt->get_result();
$fila = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Servicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Editar Servicio</h2>
    <form action="actualizar_servicio.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idSERVICIOS" value="<?= $fila['idSERVICIOS'] ?>">
        <div class="mb-3">
            <label class="form-label">Nombre:</label>
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($fila['NOMBRE']) ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" required><?= htmlspecialchars($fila['DESCRIPCION']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Detalle:</label>
            <textarea name="detalle" class="form-control" required><?= htmlspecialchars($fila['DETALLE']) ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <select name="estado" class="form-select">
                <option value="Activo" <?= $fila['ESTADO'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option value="Inactivo" <?= $fila['ESTADO'] == 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Imagen actual:</label><br>
            <?php if (!empty($fila['IMAGEN'])): ?>
                <img src="../recursos/promociones/<?= $fila['IMAGEN'] ?>" width="150" class="mb-2 rounded">
            <?php else: ?>
                <p>No hay imagen</p>
            <?php endif; ?>
            <input type="file" class="form-control mt-2" name="imagen">
        </div>
        <button type="submit" class="btn btn-success">Actualizar Servicio</button>
        <a href="../index.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>