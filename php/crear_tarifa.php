<?php include '../config/conexion.php'; ?>
<?php $conn = conectarDB(); ?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registrar Nueva Tarifa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container py-5">
    <h2 class="mb-4">Registrar Nueva Tarifa</h2>
    <form action="guardar_tarifa.php" method="POST" class="card p-4 shadow-sm">
      <div class="mb-3">
        <label for="habitaciones" class="form-label">Tipo de Habitación</label>
        <input type="text" id="habitaciones" name="habitaciones" class="form-select" required>
    
  
      </div>
      <div class="mb-3">
        <label for="capacidad" class="form-label">Capacidad</label>
        <input type="number" id="capacidad" name="capacidad" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="precio" class="form-label">Precio por Noche</label>
        <input type="number" id="precio" name="precio" class="form-control" step="0.01" required>
      </div>
      <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción</label>
        <textarea id="descripcion" name="descripcion" class="form-control" rows="3"></textarea>
      </div>
      <div class="d-flex justify-content-between">
        <a href="index.php" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">Guardar</button>
      </div>
    </form>
  </div>
</body>
</html>
