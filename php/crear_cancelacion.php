<?php
include '../config/conexion.php';
$conn = conectarDB();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $idEstadia = $_POST["idEstadia"];
  $fecha = $_POST["fecha"];
  $motivo = $_POST["motivo"];
  $porcentaje = $_POST["porcentaje"];
  $monto = $_POST["monto"];
  $estado = $_POST["estado"];
  $observaciones = $_POST["observaciones"];

  $sql = "INSERT INTO cancelacion 
          (idESTADIA, FECHACANCELACION, MOTIVOCANCELACION, PORCENTAJEREEMBOLSO, MONTOREEMBOLSADO, ESTADO, OBSERVACIONES) 
          VALUES ('$idEstadia', '$fecha', '$motivo', '$porcentaje', '$monto', '$estado', '$observaciones')";

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
  <title>Nueva Cancelación</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
  <h2 class="mb-4">Nueva Cancelación</h2>
  <form method="post" class="row g-3">
    <div class="col-md-6">
      <label class="form-label">Estadía ID</label>
      <input type="number" name="idEstadia" class="form-control" required>
    </div>
    <div class="col-md-6">
      <label class="form-label">Fecha Cancelación</label>
      <input type="date" name="fecha" class="form-control" required>
    </div>
    <div class="col-12">
      <label class="form-label">Motivo</label>
      <textarea name="motivo" class="form-control" required></textarea>
    </div>
    <div class="col-md-6">
      <label class="form-label">% Reembolso</label>
      <input type="number" name="porcentaje" class="form-control" min="0" max="100" step="0.01">
    </div>
    <div class="col-md-6">
      <label class="form-label">Monto</label>
      <input type="number" name="monto" class="form-control" step="0.01">
    </div>
    <div class="col-md-6">
      <label class="form-label">Estado</label>
      <select name="estado" class="form-select">
        <option value="Pendiente">Pendiente</option>
        <option value="Aprobado">Aprobado</option>
        <option value="Rechazado">Rechazado</option>
      </select>
    </div>
    <div class="col-12">
      <label class="form-label">Observaciones</label>
      <textarea name="observaciones" class="form-control"></textarea>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-success">Guardar</button>
      <a href="index.php" class="btn btn-secondary">Cancelar</a>
    </div>
  </form>
</body>
</html>