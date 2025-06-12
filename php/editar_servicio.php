<?php
include "../config/conexion.php";
$conn = conectarDB();
$id = $_GET['id'];

$query = "SELECT * FROM servicios WHERE idSERVICIOS='$id'";
$result = mysqli_query($conn, $query);
$fila = mysqli_fetch_assoc($result);
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
    <form action="./actualizar_servicio.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="idSERVICIOS" value="<?= $fila['idSERVICIOS'] ?>">
        <div class="mb-3">
            <label class="form-label">Descripción:</label>
            <textarea name="DESCRIPCION" class="form-control"><?= $fila['DESCRIPCION'] ?></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Estado:</label>
            <select name="ESTADO" class="form-select">
                <option <?= $fila['ESTADO'] == 'Activo' ? 'selected' : '' ?>>Activo</option>
                <option <?= $fila['ESTADO'] == 'Inactivo' ? 'selected' : '' ?>>Inactivo</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Imagen actual:</label><br>
            <?php if ($fila['IMAGEN']): ?>
                <img src="recursos/img/<?= $fila['IMAGEN'] ?>" width="100"><br>
            <?php endif; ?>
        </div>
        <div class="mb-3">
            <label class="form-label">Nueva imagen:</label>
            <input type="file" name="IMAGEN" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Actualizar Servicio</button>
        <a href="index.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>