<?php include '../config/conexion.php'; ?>
<?php $conn = conectarDB(); ?>

<form action="guardar_informe.php" method="POST" class="p-4 bg-light shadow rounded">
  <h4>Generar Informe</h4>
  <div class="form-group">
    <label>Nombre:</label>
    <input type="text" name="nombre" class="form-control" required>
  </div>
  <div class="form-group">
    <label>Fecha Check-in:</label>
    <input type="date" name="checkin" class="form-control" required>
  </div>
  <div class="form-group">
    <label>Fecha Check-out:</label>
    <input type="date" name="checkout" class="form-control" required>
  </div>
  <div class="form-group">
    <label>Tipo de habitación:</label>
    <select name="habitacion" class="form-control">
      <option value="Estándar">Estándar</option>
      <option value="Suite">Suite</option>
    </select>
  </div>
  <div class="form-check">
    <input type="checkbox" name="desayuno" value="25000" class="form-check-input">
    <label class="form-check-label">Desayuno (25.000)</label>
  </div>
  <div class="form-check">
    <input type="checkbox" name="spa" value="140000" class="form-check-input">
    <label class="form-check-label">Spa (140.000)</label>
  </div>
  <button type="submit" class="btn btn-warning mt-3">Guardar Informe</button>
</form>