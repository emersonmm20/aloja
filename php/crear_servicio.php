<?php include '../config/conexion.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Servicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Nuevo Servicio</h2>
    <form action="./guardar_servicio.php" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Nombre del servicio:</label>
            <input type="text" name="idSERVICIOS" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="DESCRIPCION" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <select name="ESTADO" class="form-select">
                <option value="Activo">Activo</option>
                <option value="Inactivo">Inactivo</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Imagen (JPG):</label>
            <input type="file" name="IMAGEN" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Guardar Servicio</button>
        <a href="index.php/" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>