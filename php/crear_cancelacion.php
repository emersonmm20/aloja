<?php
include '../config/conexion.php';
$conn = conectarDB();

// Mostrar errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Procesar formulario si se ha enviado
function CalcularMonto($porc,$monto){
    $resultado = ($porc / 100) * $monto;
    return number_format($resultado, 2, '.', '');

}
if (isset($_GET["idPago"])){
    $id= $_GET["idPago"];
    $sql="SELECT * from pagos WHERE idPAGOS =$id";
    $pago=mysqli_fetch_assoc(mysqli_query($conn,$sql));
  }
  else{
    header("Location: ../index.php?section=historial-de-pagos");
  }
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // $_POST['MONTOREEMBOLSADO'];
    $idEstadia = $_POST['idESTADIA'];
    $idHuesped = $_POST['idHUESPED'];
    $fecha = $_POST['FECHACANCELACION'];
    $motivo = $_POST['MOTIVOCANCELACION'];
    $montoPago=$_POST['MONTOPAGO'];
    $porcentaje = $_POST['PORCENTAJEREEMBOLSO'];
    $monto = CalcularMonto($porcentaje,$montoPago);
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
              '$porcentaje', '$monto', '$estado', '$observaciones');
              ";

    if (mysqli_query($conn, $query)) {
        header("Location: ../index.php?section=historial-de-pagos");
    exit;
    } else {
        echo "❌ Error al guardar: " . mysqli_error($conn);
    }

    exit;
}
?>

<?php
  



?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Cancelación</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2>Registrar Cancelación ID: <?=$id?></h2>

  <form method="post">

    <!-- Estadía, HUESPED, FECHA, monto -->
      <input type="hidden" name="idESTADIA" value="<?=$pago["ESTADIA_idESTADIA"]?>">
      <input type="hidden" name="idHUESPED" value="<?=$pago["HUESPED_idHUESPED"]?>">
      <input type="hidden" name="FECHACANCELACION" value="<?=date('Y-m-d')?>">
      <input type="hidden" name="MONTOPAGO" value="<?=$pago["MONTO"]?>">

    <!-- Motivo -->
    <div class="mb-3">
      <label class="form-label">Motivo de Cancelación</label>
      <input type="text" name="MOTIVOCANCELACION" class="form-control" require>
    </div>

    <!-- Porcentaje Reembolso -->
    <div class="mb-3">
      <label class="form-label">Porcentaje de Reembolso (%)</label>
      <input type="number" name="PORCENTAJEREEMBOLSO" class="form-control" step="0.1" min="0" max="100">
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
    <a href="../index.php?section=historial-de-pagos" class="btn btn-secondary">Cancelar</a>

  </form>

  <hr>
  <!-- <p class="text-muted">Formulario cargado completamente.</p> -->
</body>
</html>