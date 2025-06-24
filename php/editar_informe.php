<?php
include '../config/conexion.php';

$conexion = conectarDB();

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $resultado = $conexion->query("SELECT * FROM informes WHERE id = $id");
    $informe = $resultado->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $checkin = $_POST['fecha_checkin'];
    $checkout = $_POST['fecha_checkout'];
    $habitacion = $_POST['tipo_habitacion'];
    $noches = $_POST['noches'];
    $desayuno = isset($_POST['desayuno']) ? 1 : 0;
    $spa = isset($_POST['spa']) ? 1 : 0;
    $total = $_POST['total'];

    $sql = "UPDATE informes SET 
                nombre='$nombre',
                fecha_checkin='$checkin',
                fecha_checkout='$checkout',
                tipo_habitacion='$habitacion',
                noches='$noches',
                desayuno='$desayuno',
                spa='$spa',
                total='$total'
            WHERE id = $id";

    if ($conexion->query($sql)) {
        header("Location: index.php"); // Redirige de nuevo al listado
        exit();
    } else {
        echo "Error al actualizar el informe: " . $conexion->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Informe</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h2>Editar Informe</h2>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?= $informe['nombre'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha Check-in</label>
            <input type="date" name="fecha_checkin" class="form-control" value="<?= $informe['fecha_checkin'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha Check-out</label>
            <input type="date" name="fecha_checkout" class="form-control" value="<?= $informe['fecha_checkout'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo de Habitación</label>
            <input type="text" name="tipo_habitacion" class="form-control" value="<?= $informe['tipo_habitacion'] ?>" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Noches</label>
            <input type="number" name="noches" class="form-control" value="<?= $informe['noches'] ?>" required>
        </div>
        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="desayuno" <?= $informe['desayuno'] ? 'checked' : '' ?>>
            <label class="form-check-label">Desayuno</label>
        </div>
        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="spa" <?= $informe['spa'] ? 'checked' : '' ?>>
            <label class="form-check-label">Spa</label>
        </div>
        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="number" name="total" class="form-control" value="<?= $informe['total'] ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>