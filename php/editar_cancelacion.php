<?php
include '../config/conexion.php';
$id = $_GET['id'];

$resultado = mysqli_query($conn, "SELECT * FROM cancelacion WHERE idCANCELACION = $id");
$fila = mysqli_fetch_assoc($resultado);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $idEstadia = $_POST["idEstadia"];
  $fecha = $_POST["fecha"];
  $motivo = $_POST["motivo"];
  $porcentaje = $_POST["porcentaje"];
  $monto = $_POST["monto"];
  $estado = $_POST["estado"];
  $observaciones = $_POST["observaciones"];

  $sql = "UPDATE cancelacion SET 
          idESTADIA='$idEstadia', 
          FECHACANCELACION='$fecha', 
          MOTIVOCANCELACION='$motivo', 
          PORCENTAJEREEMBOLSO='$porcentaje', 
          MONTOREEMBOLSADO='$monto', 
          ESTADO='$estado', 
          OBSERVACIONES='$observaciones'
          WHERE idCANCELACION=$id";

  if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
    exit();
  } else {
    echo "Error: " . mysqli_error($conn);
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
<body class="container py-5">
  <h2 class="mb-4">Editar Cancelación</h2>
  <form method="post" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Estadía ID</label>
      <input type="number" name="idEstadia" class="form-control" value="<?= $fila['idESTADIA'] ?>" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Fecha Cancelación</label>
      <input type="date" name="fecha" class="form-control" value="<?= $fila['FECHACANCELACION'] ?>" required>
    </div>
    <div class="col-12">
      <label class="form-label">Motivo</label>
      <textarea name="motivo" class="form-control" required><?= $fila['MOTIVOCANCELACION'] ?></textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">% Reembolso</label>
      <input type="number" name="porcentaje" class="form-control" value="<?= $fila['PORCENTAJEREEMBOLSO'] ?>" step="0.01">
    </div>
    <div class="col-md-6">
      <label class="form-label">Monto</label>
      <input type="number" name="monto" class="form-control" value="<?= $fila['MONTOREEMBOLSADO'] ?>" step="0.01">
    </div>
    <div class="col-md-6">
      <label class="form-label">Estado</label>
      <select name="estado" class="form-select">
        <option value="Pendiente" <?= $fila['ESTADO'] == "Pendiente" ? "selected" : "" ?>>Pendiente</option>
        <option value="Aprobado" <?= $fila['ESTADO'] == "Aprobado" ? "selected" : "" ?>>Aprobado</option>
        <option value="Rechazado" <?= $fila['ESTADO'] == "Rechazado" ? "selected" : "" ?>>Rechazado</option>
      </select>
    </div>
    <div class="col-12">
      <label class="form-label">Observaciones</label>
      <textarea name="observaciones" class="form-control"><?= $fila['OBSERVACIONES'] ?></textarea>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-primary">Actualizar</button>
      <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</body>
</html>