<?php
include '../config/conexion.php';
$conn = conectarDB();

if (!isset($_GET['id'])) {
    die("❌ ID de cancelación no especificado.");
}

$id = $_GET['id'];
$resultado = mysqli_query($conn, "SELECT * FROM cancelacion WHERE idCANCELACION = $id");

if (!$resultado || mysqli_num_rows($resultado) == 0) {
    die("❌ Cancelación no encontrada.");
}

$cancelacion = mysqli_fetch_assoc($resultado);

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idEstadia = $_POST['idESTADIA'];
    $idHuesped = $_POST['idHUESPED'];
    $fecha = $_POST['FECHACANCELACION'];
    $motivo = $_POST['MOTIVOCANCELACION'];
    $porcentaje = $_POST['PORCENTAJEREEMBOLSO'];
    $monto = $_POST['MONTOREEMBOLSADO'];
    $estado = $_POST['ESTADO'];
    $observaciones = $_POST['OBSERVACIONES'];

    $update = "UPDATE cancelacion SET 
        idESTADIA = '$idEstadia',
        idHUESPED = '$idHuesped',
        FECHACANCELACION = '$fecha',
        MOTIVOCANCELACION = '$motivo',
        PORCENTAJEREEMBOLSO = '$porcentaje',
        MONTOREEMBOLSADO = '$monto',
        ESTADO = '$estado',
        OBSERVACIONES = '$observaciones'
        WHERE idCANCELACION = $id";

    if (mysqli_query($conn, $update)) {
        header("Location: ../index.php?mensaje=cancelacion_editada");
        exit;
    } else {
        echo "❌ Error al actualizar: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Editar Cancelación</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Editar Cancelación</h2>
  <form method="post">
    <!-- Estadía -->
    <div class="mb-3">
      <label class="form-label">Estadía</label>
      <select name="idESTADIA" class="form-select" required>
        <?php
        $est = mysqli_query($conn, "SELECT idESTADIA FROM estadia");
        while ($row = mysqli_fetch_assoc($est)) {
          $selected = $row['idESTADIA'] == $cancelacion['idESTADIA'] ? 'selected' : '';
          echo "<option value='{$row['idESTADIA']}' $selected>{$row['idESTADIA']}</option>";
        }
        ?>
      </select>
    </div>

    <!-- Huésped -->
    <div class="mb-3">
      <label class="form-label">Huésped</label>
      <select name="idHUESPED" class="form-select" required>
        <?php
        $huespedes = mysqli_query($conn, "SELECT idHUESPED, NOMBRECOMPLETO FROM huesped");
        while ($h = mysqli_fetch_assoc($huespedes)) {
          $selected = $h['idHUESPED'] == $cancelacion['idHUESPED'] ? 'selected' : '';
          echo "<option value='{$h['idHUESPED']}' $selected>{$h['NOMBRECOMPLETO']}</option>";
        }
        ?>
      </select>
    </div>

    <!-- Otros campos -->
    <div class="mb-3">
      <label class="form-label">Fecha de Cancelación</label>
      <input type="date" name="FECHACANCELACION" class="form-control" value="<?= $cancelacion['FECHACANCELACION'] ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Motivo</label>
      <input type="text" name="MOTIVOCANCELACION" class="form-control" value="<?= $cancelacion['MOTIVOCANCELACION'] ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Porcentaje de Reembolso</label>
      <input type="number" name="PORCENTAJEREEMBOLSO" class="form-control" value="<?= $cancelacion['PORCENTAJEREEMBOLSO'] ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Monto Reembolsado</label>
      <input type="number" name="MONTOREEMBOLSADO" class="form-control" value="<?= $cancelacion['MONTOREEMBOLSADO'] ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Estado</label>
      <select name="ESTADO" class="form-select">
        <?php
        $estados = ['Pendiente', 'Reembolsado', 'No aplica'];
        foreach ($estados as $estado) {
          $selected = $estado == $cancelacion['ESTADO'] ? 'selected' : '';
          echo "<option value='$estado' $selected>$estado</option>";
        }
        ?>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Observaciones</label>
      <textarea name="OBSERVACIONES" class="form-control"><?= $cancelacion['OBSERVACIONES'] ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <a href="../index.php" class="btn btn-secondary">Cancelar</a>
  </form>
</body>
</html>