<?php
include '../config/conexion.php';
$conn = conectarDB();

// Mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Procesar formulario si se ha enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idEstadia = $_POST['idESTADIA'];
    $idHuesped = $_POST['idHUESPED'];
    $fecha = $_POST['FECHACANCELACION'];
    $motivo = $_POST['MOTIVOCANCELACION'];
    $porcentaje = $_POST['PORCENTAJEREEMBOLSO'];
    $monto = $_POST['MONTOREEMBOLSADO'];
    $estado = $_POST['ESTADO'];
    $observaciones = $_POST['OBSERVACIONES'];

    // Validar claves foráneas
    $checkEstadia = mysqli_query($conn, "SELECT idESTADIA FROM estadia WHERE idESTADIA = $idEstadia");
    $checkHuesped = mysqli_query($conn, "SELECT idHUESPED FROM huesped WHERE idHUESPED = $idHuesped");

    if (mysqli_num_rows($checkEstadia) == 0) {
        die("❌ Error: El idESTADIA no existe.");
    }
    if (mysqli_num_rows($checkHuesped) == 0) {
        die("❌ Error: El idHUESPED no existe.");
    }

    $query = "INSERT INTO cancelacion (idESTADIA, idHUESPED, FECHACANCELACION, MOTIVOCANCELACION, 
              PORCENTAJEREEMBOLSO, MONTOREEMBOLSADO, ESTADO, OBSERVACIONES) 
              VALUES ('$idEstadia', '$idHuesped', '$fecha', '$motivo', 
              '$porcentaje', '$monto', '$estado', '$observaciones')";

    if (mysqli_query($conn, $query)) {
        header("Location: ../index.php?mensaje=cancelacion_guardada");
    exit;
    } else {
        echo "❌ Error al guardar: " . mysqli_error($conn);
    }

    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Cancelación</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Registrar Cancelación</h2>

  <form method="post">

    <!-- Estadía -->
    <div class="mb-3">
      <label class="form-label">Estadía</label>
      <select name="idESTADIA" class="form-select" required>
        <option value="">Seleccione</option>
        <?php
        $est = mysqli_query($conn, "SELECT idESTADIA FROM estadia") 
              or die('❌ Error al consultar estadías: ' . mysqli_error($conn));
        while ($row = mysqli_fetch_assoc($est)) {
          echo "<option value='{$row['idESTADIA']}'>{$row['idESTADIA']}</option>";
        }
        ?>
      </select>
    </div>

    <!-- Huésped -->
    <div class="mb-3">
      <label class="form-label">Huésped</label>
      <select name="idHUESPED" class="form-select" required>
        <option value="">Seleccione</option>
        <?php
        $huespedes = mysqli_query($conn, "SELECT idHUESPED, NOMBRECOMPLETO FROM huesped") 
                    or die('❌ Error al consultar huéspedes: ' . mysqli_error($conn));

        if (mysqli_num_rows($huespedes) == 0) {
            echo "<option value=''>No hay huéspedes registrados</option>";
        } else {
            while ($h = mysqli_fetch_assoc($huespedes)) {
                echo "<option value='{$h['idHUESPED']}'>{$h['NOMBRECOMPLETO']}</option>";
            }
        }
        ?>
      </select>
    </div>

    <!-- Fecha -->
    <div class="mb-3">
      <label class="form-label">Fecha de Cancelación</label>
      <input type="date" name="FECHACANCELACION" class="form-control" required>
    </div>

    <!-- Motivo -->
    <div class="mb-3">
      <label class="form-label">Motivo de Cancelación</label>
      <input type="text" name="MOTIVOCANCELACION" class="form-control">
    </div>

    <!-- Porcentaje Reembolso -->
    <div class="mb-3">
      <label class="form-label">Porcentaje de Reembolso (%)</label>
      <input type="number" name="PORCENTAJEREEMBOLSO" class="form-control" step="0.1" min="0" max="100">
    </div>

    <!-- Monto Reembolsado -->
    <div class="mb-3">
      <label class="form-label">Monto Reembolsado</label>
      <input type="number" name="MONTOREEMBOLSADO" class="form-control" step="0.01" min="0">
    </div>

    <!-- Estado -->
    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select name="ESTADO" class="form-select">
        <option value="Pendiente">Pendiente</option>
        <option value="Reembolsado">Reembolsado</option>
        <option value="No aplica">No aplica</option>
      </select>
    </div>

    <!-- Observaciones -->
    <div class="mb-3">
      <label class="form-label">Observaciones</label>
      <textarea name="OBSERVACIONES" class="form-control"></textarea>
    </div>

    <!-- Botones -->
    <button type="submit" class="btn btn-success">Guardar Cancelación</button>
    <a href="../index.php" class="btn btn-secondary">Cancelar</a>
  </form>

  <hr>
  <p class="text-muted">Formulario cargado completamente.</p>
</body>
</html>