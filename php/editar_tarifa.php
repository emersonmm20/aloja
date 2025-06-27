<?php
include '../config/conexion.php';
$conn = conectarDB();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM tarifas WHERE idTARIFAS = $id");
    $tarifa = $result->fetch_assoc();

    $habitaciones = $conn->query("SELECT * FROM habitaciones");
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $habitacion_id = $_POST['numeroHabitaciones'];
    $capacidad = $_POST['capacidad'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];

    $sql = "UPDATE tarifas SET idHABITACIONES = ?, CAPACIDAD = ?, PRECIOPORNOCHE = ?, DESCRIPCION = ? WHERE idTARIFAS = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iidsi", $habitacion_id, $capacidad, $precio, $descripcion, $id);

    if ($stmt->execute()) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Error al actualizar la tarifa: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Tarifa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">Editar Tarifa</h2>
    <form action="editar_tarifa.php" method="POST" class="card p-4 shadow-sm">
      <input type="hidden" name="id" value="<?= $tarifa['idTARIFAS'] ?>">
      <div class="mb-3">
        <label for="numeroHabitaciones" class="form-label">Número de Habitación</label>
        <select id="numeroHabitaciones" name="numeroHabitaciones" class="form-select" required>
          <?php while ($fila = $habitaciones->fetch_assoc()): ?>
            <option value="<?= $fila['idHABITACIONES'] ?>" <?= $tarifa['idHABITACIONES'] == $fila['idHABITACIONES'] ? 'selected' : '' ?>>
              <?= $fila['NUMERO'] ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="mb-3">
        <label for="capacidad" class="form-label">Capacidad</label>
        <input type="number" id="capacidad" name="capacidad" class="form-control" value="<?= $tarifa['CAPACIDAD'] ?>" required>
      </div>
      <div class="mb-3">
        <label for="precio" class="form-label">Precio por Noche</label>
        <input type="number" id="precio" name="precio" class="form-control" value="<?= $tarifa['PRECIOPORNOCHE'] ?>" step="0.01" required>
      </div>
      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="form-control" rows="3"><?= $tarifa['DESCRIPCION'] ?></textarea>
      </div>
      <div class="d-flex justify-content-between">
        <a href="../index.php" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Actualizar</button>
      </div>
    </form>
  </div>
</body>
</html>