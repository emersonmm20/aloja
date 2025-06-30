<?php
include '../config/conexion.php'; 
$conn = conectarDB();
$habitaciones = mysqli_query($conn, "SELECT idHABITACIONES, NUMERO FROM habitaciones");
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Registrar Nuevo Informe</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background-color: #f8f9fa; }
    .form-card { max-width: 650px; margin: 40px auto; }
  </style>
</head>
<body>
  <div class="container form-card">
    <div class="card shadow">
      <div class="card-header text-dark text-center">
        <h4 class="mb-2">Registrar Nuevo Informe</h4>
      </div>
      <div class="card-body">
        <form action="guardar_informe.php" method="POST">
          
          <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Fecha Check-in</label>
              <input type="date" name="fecha_checkin" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
              <label class="form-label">Fecha Check-out</label>
              <input type="date" name="fecha_checkout" class="form-control" required>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label class="form-label">Número de habitación</label>
              <select name="id_habitacion" class="form-select" required>
                <option value="">Seleccione una habitación</option>
                <?php while ($hab = mysqli_fetch_assoc($habitaciones)) : ?>
                  <option value="<?= $hab['idHABITACIONES'] ?>">Habitación <?= $hab['NUMERO'] ?></option>
                <?php endwhile; ?>
              </select>
            </div>
        
          </div>

          <div class="mb-3">
            <label class="form-label d-block">Servicios</label>
            <div class="form-check form-check-inline">
              <input type="checkbox" name="desayuno" value="1" class="form-check-input" id="checkDesayuno">
              <label class="form-check-label" for="checkDesayuno">Desayuno</label>
            </div>
            <div class="form-check form-check-inline">
              <input type="checkbox" name="spa" value="1" class="form-check-input" id="checkSpa">
              <label class="form-check-label" for="checkSpa">Spa</label>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Total ($)</label>
            <input type="number" name="total" class="form-control" step="0.01" min="0" required>
          </div>

          <div class="d-flex justify-content-between">
            <a href="../index.php" class="btn btn-secondary">Volver</a>
            <button type="submit" class="btn btn-warning">Guardar Informe</button>
          </div>

        </form>
      </div>
    </div>
  </div>
</body>
</html>