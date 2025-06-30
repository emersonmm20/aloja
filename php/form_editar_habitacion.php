<?php
include '../config/conexion.php';

$conn = conectarDB();

if (!isset($_GET['id'])) {
    echo "ID no proporcionado.";
    exit;
}

$id = $_GET['id'];
$query = "SELECT * FROM habitaciones WHERE idHABITACIONES = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Habitación no encontrada.";
    exit;
}

$habitacion = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Habitación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Editar Habitación #<?= $habitacion['NUMERO'] ?></h4>
            </div>
            <div class="card-body">
                <form action="editar_habitacion.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?= $habitacion['idHABITACIONES'] ?>">

                    <div class="mb-3">
                        <label for="numero" class="form-label">Número de habitación</label>
                        <input type="number" class="form-control" name="numero" id="numero" value="<?= $habitacion['NUMERO'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="capacidad" class="form-label">Capacidad</label>
                        <input type="number" class="form-control" name="capacidad" id="capacidad" value="<?= $habitacion['CAPACIDAD'] ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" name="estado" id="estado">
                            <option value="OCUPADA" <?= $habitacion['ESTADO'] == 'OCUPADA' ? 'selected' : '' ?>>Ocupada</option>
                            <option value="DESOCUPADA" <?= $habitacion['ESTADO'] == 'DESOCUPADA' ? 'selected' : '' ?>>Desocupada</option>
                            <option value="FUERA_DE_SERVICIO" <?= $habitacion['ESTADO'] == 'FUERA_DE_SERVICIO' ? 'selected' : '' ?>>Fuera de servicio</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="4" required><?= htmlspecialchars($habitacion['DESCRIPCION']) ?></textarea>
                    </div>


                    <div class="mb-3">
                        <label for="precio" class="form-label">Precio por noche (COP)</label>
                        <input type="number" class="form-control" name="precio" id="precio" step="0.01" value="<?= $habitacion['PRECIO'] ?>" required>
                    </div>


                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen actual</label><br>
                        <?php if (!empty($habitacion['IMAGEN'])): ?>
                            <img src="../img/habitaciones/<?= $habitacion['IMAGEN'] ?>" width="150" class="mb-2 rounded">
                        <?php else: ?>
                            <p>No hay imagen</p>
                        <?php endif; ?>
                        <input type="file" class="form-control mt-2" name="imagen" id="imagen">
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="../index.php" class="btn btn-secondary">Volver</a>
                        <button type="submit" class="btn btn-success">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>


