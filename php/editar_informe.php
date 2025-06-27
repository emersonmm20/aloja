<?php
include '../config/conexion.php';
$conn = conectarDB();

// Cargar habitaciones
$habitaciones = $conn->query("SELECT * FROM habitaciones");

// Validar ID
if (!isset($_GET['id'])) {
    echo "<script>alert('ID de informe no especificado'); window.location.href='../index.php';</script>";
    exit;
}

$id = intval($_GET['id']);

// Obtener el informe
$resultado = $conn->query("SELECT * FROM informes WHERE idINFORMES = $id");

if (!$resultado || $resultado->num_rows == 0) {
    echo "<script>alert('Informe no encontrado'); window.location.href='../index.php';</script>";
    exit;
}

$informe = $resultado->fetch_assoc();

// Actualizar si envían el formulario
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $fecha_checkin = $_POST['fecha_checkin'];
    $fecha_checkout = $_POST['fecha_checkout'];
    $id_habitacion = $_POST['numero_habitacion'];
    $noches = $_POST['noches'];
    $desayuno = isset($_POST['desayuno']) ? 1 : 0;
    $spa = isset($_POST['spa']) ? 1 : 0;
    $total = $_POST['total'];

    $sql = "UPDATE informes SET 
                NOMBRE = '$nombre',
                FECHA_CHECKIN = '$fecha_checkin',
                FECHA_CHECKOUT = '$fecha_checkout',
                IDHABITACIONES = $id_habitacion,
                NOCHES = $noches,
                DESAYUNO = $desayuno,
                SPA = $spa,
                TOTAL = $total
            WHERE idINFORMES = $id";

    if ($conn->query($sql)) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al actualizar el informe: " . $conn->error;
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
            <input type="text" name="nombre" class="form-control" value="<?= htmlspecialchars($informe['NOMBRE']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha Check-in</label>
            <input type="date" name="fecha_checkin" class="form-control" value="<?= $informe['FECHA_CHECKIN'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Fecha Check-out</label>
            <input type="date" name="fecha_checkout" class="form-control" value="<?= $informe['FECHA_CHECKOUT'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Habitación</label>
            <select name="numero_habitacion" class="form-select" required>
                <?php while ($hab = $habitaciones->fetch_assoc()): ?>
                    <option value="<?= $hab['idHABITACIONES'] ?>" <?= $hab['idHABITACIONES'] == $informe['IDHABITACIONES'] ? 'selected' : '' ?>>
                        Habitación <?= $hab['NUMERO'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Noches</label>
            <input type="number" name="noches" class="form-control" value="<?= $informe['NOCHES'] ?>" required>
        </div>

        <div class="form-check mb-2">
            <input class="form-check-input" type="checkbox" name="desayuno" <?= !empty($informe['DESAYUNO']) ? 'checked' : '' ?>>
            <label class="form-check-label">Desayuno</label>
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="spa" <?= !empty($informe['SPA']) ? 'checked' : '' ?>>
            <label class="form-check-label">Spa</label>
        </div>

        <div class="mb-3">
            <label class="form-label">Total</label>
            <input type="number" name="total" class="form-control" value="<?= $informe['TOTAL'] ?>" required>
        </div>

        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        <a href="../index.php" class="btn btn-secondary">Cancelar</a>
    </form>
</body>
</html>